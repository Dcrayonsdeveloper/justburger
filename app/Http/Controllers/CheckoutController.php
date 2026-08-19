<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Models\AbandonedCheckout;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Affiliate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\UserAddress;
use App\Services\AnalyticsService;
use App\Services\StripeOrderService;
use App\Services\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private function logActivity(string $event, array $details = [], ?Request $request = null): void
    {
        try {
            $r = $request ?? request();
            DB::table('customer_activity_logs')->insert([
                'session_id' => session()->getId(),
                'user_id' => auth()->id(),
                'guest_email' => $r->input('guest_email'),
                'guest_phone' => $r->input('guest_phone'),
                'event' => $event,
                'details' => json_encode($details),
                'ip_address' => $r->ip(),
                'user_agent' => $r->userAgent(),
                'page_url' => $r->fullUrl(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Activity log failed', ['event' => $event, 'error' => $e->getMessage()]);
        }
    }

    public function index(): View|RedirectResponse
    {
        $this->logActivity('checkout_viewed');
        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $isGuest = !auth()->check();
        $addresses = $isGuest ? collect() : UserAddress::where('user_id', auth()->id())->get();
        // ?address=<id> lets the page come back with the address the customer
        // just saved already selected, rather than falling back to the default.
        $defaultAddress = $addresses->firstWhere('id', (int) request('address'))
            ?? $addresses->where('is_default', true)->first()
            ?? $addresses->first();

        $paymentSettings = Setting::where('group', 'payment')->pluck('value', 'key');

        // Fetch only coupons that are valid for this cart's subtotal
        $cartSubtotal = $cart->subtotal;
        $availableCoupons = Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereColumn('times_used', '<', 'usage_limit');
            })
            ->where(function ($q) use ($cartSubtotal) {
                $q->where('min_order_amount', '<=', $cartSubtotal)
                  ->orWhere('min_order_amount', 0);
            })
            ->orderByDesc('value')
            ->get();

        // Navratri offer active check
        $navratriActive = Setting::get('navratri_offer_active', '1') === '1';

        // Shipping fee calculation for display
        $freeShipThreshold = (float) Setting::get('free_shipping_threshold', 499);
        $shippingFee = ($cart->subtotal - $cart->discount) >= $freeShipThreshold ? 0 : 50;

        // Record abandoned checkout
        $this->recordAbandonedCheckout($cart, 'checkout');

        // Facebook CAPI: InitiateCheckout
        $fbEventId = AnalyticsService::generateEventId('ic');
        $contentIds = $cart->items->pluck('product_id')->map(fn ($id) => (string) $id)->toArray();
        app(AnalyticsService::class)->trackInitiateCheckout(
            (float) ($cart->subtotal - $cart->discount),
            $cart->items->sum('quantity'),
            $contentIds,
            request(),
            $fbEventId
        );

        // One-click checkout: check if user has preferences saved
        $oneClickReady = false;
        $checkoutPreference = null;
        if (!$isGuest) {
            $checkoutPreference = \App\Models\UserCheckoutPreference::where('user_id', auth()->id())->first();
            $oneClickReady = $checkoutPreference
                && $checkoutPreference->enable_one_click
                && $checkoutPreference->default_shipping_address_id
                && $defaultAddress;
        }

        // Loyalty points
        $loyaltyPoints = 0;
        $loyaltyValue = 0;
        $loyaltyEnabled = (bool) Setting::get('loyalty_enabled', true);
        if (!$isGuest && $loyaltyEnabled) {
            $loyaltyPoints = auth()->user()->loyalty_points_balance ?? 0;
            $loyaltyValue = round($loyaltyPoints * (float) Setting::get('loyalty_redeem_rate', 0.25), 2);
        }

        return view('checkout.index', compact(
            'cart', 'addresses', 'defaultAddress', 'paymentSettings',
            'isGuest', 'availableCoupons', 'navratriActive', 'fbEventId',
            'oneClickReady', 'checkoutPreference', 'loyaltyPoints', 'loyaltyValue'
        ));
    }

    public function process(Request $request): RedirectResponse
    {
        $isGuest = !auth()->check();

        $rules = [
            'same_billing_address' => ['nullable', 'boolean'],
            'payment_method' => ['required', 'string', 'in:cod,partial_pay'],
            'notes' => ['nullable', 'string', 'max:500'],
            'delivery_method' => ['nullable', 'string', 'in:collection'],
            // Collection only — we just capture the customer's name.
            'guest_name' => ['required', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        // Delivery validation rules
        // Collection only — delivery was withdrawn, so there is never a fee,
        // no minimum order and no delivery window to police.
        $isDelivery = false;
        if ($isDelivery) {
            $ukNow = now('Europe/London');
            $dayOfWeek = (int) $ukNow->format('N'); // 1=Mon, 7=Sun
            $hour = (int) $ukNow->format('G');

            if ($dayOfWeek === 7) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Sorry, we do not deliver on Sundays. Please choose Collection or order on another day.');
            }
            if ($hour < 10 || $hour >= 16) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Delivery is available Monday–Saturday, 10:00 AM – 4:00 PM only. Please choose Collection or try during delivery hours.');
            }
        }

        $cart = $this->getCart(['items.product', 'items.variant', 'coupon']);

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Re-validate stock
        foreach ($cart->items as $item) {
            $available = $item->variant_id
                ? $item->variant->stock_quantity
                : $item->product->stock_quantity;

            if ($available < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "\"{$item->product->name}\" only has {$available} item(s) in stock. Please update your cart.");
            }
        }

        // Collection only — no delivery address is taken, so we snapshot just the
        // customer's name and keep the rest of the shape empty for downstream views.
        $customerName = $validated['guest_name'];
        $shippingSnapshot = [
            'name' => $customerName,
            'phone' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'country' => '',
        ];
        $billingSnapshot = $shippingSnapshot;
        $shippingAddressId = null;
        $billingAddressId = null;

        // Navratri offer: 5% extra off on all orders (after coupon discounts)
        $paymentMethod = $validated['payment_method'];
        $navratriDiscount = 0;
        $navratriActive = Setting::get('navratri_offer_active', '1') === '1';
        if ($navratriActive) {
            $navratriDiscount = round(($cart->subtotal - $cart->discount) * 0.05, 2);
        }

        $totalDiscount = $cart->discount + $navratriDiscount;

        // Loyalty points redemption
        $loyaltyPointsUsed = 0;
        $loyaltyDiscount = 0;
        if (!$isGuest && $request->boolean('use_loyalty_points') && (bool) Setting::get('loyalty_enabled', true)) {
            $user = auth()->user();
            $pointsAvailable = $user->loyalty_points_balance ?? 0;
            $redeemRate = (float) Setting::get('loyalty_redeem_rate', 0.25);
            $maxDiscount = $pointsAvailable * $redeemRate;
            $loyaltyDiscount = min($maxDiscount, $cart->subtotal - $totalDiscount); // Can't exceed order value
            $loyaltyPointsUsed = (int) ceil($loyaltyDiscount / $redeemRate);
            $totalDiscount += $loyaltyDiscount;
        }

        // Delivery fee: £5 for delivery (min £25 order), £0 for collection
        $shippingFee = 0;
        if ($isDelivery) {
            $deliveryMinOrder = (float) Setting::get('delivery_min_order', 25);
            $afterDiscount = $cart->subtotal - $totalDiscount;
            if ($afterDiscount < $deliveryMinOrder) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Minimum order for delivery is £' . number_format($deliveryMinOrder, 2) . '. Please add more items or choose Collection.');
            }
            $shippingFee = (float) Setting::get('delivery_fee', 5);
        }

        $finalTotal = max(0, $cart->subtotal - $totalDiscount + $shippingFee);

        // Cash on collection: no advance and no minimum — the customer pays in full
        // when they collect the order, so placing the order is all that's needed.
        $codAdvance = 0;

        // Resolve affiliate from cookie/session
        $affiliateId = null;
        $affiliateRefCode = null;
        $refCode = session('affiliate_ref') ?? request()->cookie(config('affiliate.cookie_name', 'justburgers_ref'));
        if ($refCode) {
            $affiliate = Affiliate::where('referral_code', $refCode)->where('status', 'approved')->first();
            if ($affiliate) {
                $affiliateId = $affiliate->id;
                $affiliateRefCode = $refCode;
            }
        }

        $order = DB::transaction(function () use ($cart, $shippingSnapshot, $billingSnapshot, $shippingAddressId, $billingAddressId, $validated, $isGuest, $finalTotal, $totalDiscount, $paymentMethod, $navratriDiscount, $codAdvance, $affiliateId, $affiliateRefCode, $shippingFee, $loyaltyPointsUsed, $loyaltyDiscount, $isDelivery) {
            $metadata = ['payment_method' => $paymentMethod, 'delivery_method' => $isDelivery ? 'delivery' : 'collection'];
            if ($navratriDiscount > 0) {
                $metadata['navratri_discount'] = $navratriDiscount;
            }
            if ($codAdvance > 0) {
                $metadata['cod_advance'] = $codAdvance;
                $metadata['cod_balance'] = $finalTotal - $codAdvance;
            }
            if ($affiliateRefCode) {
                $metadata['affiliate_referral_code'] = $affiliateRefCode;
            }
            if ($loyaltyPointsUsed > 0) {
                $metadata['loyalty_points_used'] = $loyaltyPointsUsed;
                $metadata['loyalty_discount'] = $loyaltyDiscount;
            }

            $order = Order::create([
                'user_id' => $isGuest ? null : auth()->id(),
                'guest_email' => $validated['guest_email'] ?? null,
                'guest_name' => $validated['guest_name'] ?? null,
                'guest_phone' => $validated['guest_phone'] ?? null,
                // Placing the order sends it straight to the kitchen; there is no
                // intermediate state anyone acts on. preparing_at starts the
                // collection clock — see Order::releaseOrdersDueForCollection().
                'status' => Order::STATUS_PREPARING,
                'preparing_at' => now(),
                'payment_status' => 'pending',
                'subtotal' => $cart->subtotal,
                'discount' => $totalDiscount,
                'shipping_cost' => $shippingFee,
                'tax' => 0,
                'total' => $finalTotal,
                'paid_amount' => $codAdvance,
                'coupon_id' => $cart->coupon_id,
                'affiliate_id' => $affiliateId,
                'affiliate_referral_code' => $affiliateRefCode,
                'shipping_address_id' => $shippingAddressId,
                'billing_address_id' => $billingAddressId,
                'shipping_address_snapshot' => $shippingSnapshot,
                'billing_address_snapshot' => $billingSnapshot,
                'notes' => $validated['notes'],
                'metadata' => $metadata,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'seller_id' => $item->product->seller_id,
                    'product_name' => $item->product->name,
                    'sku' => $item->product->sku ?? '',
                    'variant_name' => $item->variant?->attributeValues->pluck('value')->join(' / '),
                    'quantity' => $item->quantity,
                    'mrp' => $item->product->mrp ?? $item->price,
                    'price' => $item->price,
                    'tax' => 0,
                    'discount' => 0,
                    'total' => $item->price * $item->quantity,
                ]);

                // Atomic stock decrement with check to prevent overselling
                if ($item->variant_id) {
                    $updated = DB::table('product_variants')
                        ->where('id', $item->variant_id)
                        ->where('stock_quantity', '>=', $item->quantity)
                        ->update(['stock_quantity' => DB::raw("stock_quantity - {$item->quantity}")]);
                } else {
                    $updated = DB::table('products')
                        ->where('id', $item->product_id)
                        ->where('stock_quantity', '>=', $item->quantity)
                        ->update(['stock_quantity' => DB::raw("stock_quantity - {$item->quantity}")]);
                }

                if (!$updated) {
                    throw new \RuntimeException("Insufficient stock for \"{$item->product->name}\". Please try again.");
                }

                $item->product->increment('sales_count', $item->quantity);
            }

            // Re-validate coupon at order creation
            if ($cart->coupon) {
                $coupon = $cart->coupon;
                if (!$coupon->is_active || ($coupon->expires_at && $coupon->expires_at < now()) || ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit)) {
                    Log::warning('Coupon expired/exhausted at checkout', ['coupon' => $coupon->code]);
                } else {
                    $coupon->increment('times_used');
                }
            }

            $cart->items()->delete();
            $cart->update(['coupon_id' => null, 'discount' => 0]);

            return $order;
        });

        // Redeem loyalty points inside try/catch
        if ($loyaltyPointsUsed > 0 && !$isGuest) {
            try {
                app(\App\Services\LoyaltyService::class)->redeem(auth()->user(), $loyaltyPointsUsed, $order);
            } catch (\Exception $e) {
                Log::error('Loyalty points redemption failed', ['order' => $order->id, 'error' => $e->getMessage()]);
            }
        }

        // Mark abandoned checkout as recovered → linked to order
        $this->markAbandonedRecovered($cart, $order);

        if ($isGuest) {
            session()->put('guest_order_id', $order->id);

            // Auto-create account for guest and send credentials
            $this->createAccountForGuest($order, $validated);
        } else {
            // Save checkout preferences for one-click checkout next time
            \App\Models\UserCheckoutPreference::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'default_shipping_address_id' => $order->shipping_address_id ?? ($request->input('shipping_address_id')),
                    'default_payment_method' => $request->input('payment_method', 'cod'),
                    'same_as_shipping' => $request->boolean('same_billing_address', true),
                    'enable_one_click' => true,
                ]
            );
        }

        OrderPlaced::dispatch($order, 'web');

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        if (auth()->check()) {
            abort_unless($order->user_id === auth()->id(), 403);
        } else {
            abort_unless(session('guest_order_id') === $order->id, 403);
        }

        // Stripe fallback confirmation: if the customer landed here from Stripe's hosted
        // checkout and the webhook hasn't confirmed yet (or isn't configured), verify the
        // session server-side and confirm now. StripeOrderService::confirm is idempotent,
        // so this never double-processes an order the webhook already handled.
        if (($order->metadata['payment_method'] ?? null) === 'stripe'
            && $order->payment_status !== 'paid'
            && !empty($order->metadata['stripe_session_id'])) {
            try {
                $session = app(StripeService::class)->retrieveSession($order->metadata['stripe_session_id']);
                if ($session && ($session['payment_status'] ?? null) === 'paid') {
                    app(StripeOrderService::class)->confirm($order, $session);
                    $order->refresh();
                }
            } catch (\Throwable $e) {
                Log::warning('Stripe success-page confirmation failed', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        $order->load(['items.product']);

        // Generate event_id for Purchase dedup (shared between client fbq and server CAPI)
        $fbPurchaseEventId = AnalyticsService::generateEventId('pur');

        // Facebook CAPI: Purchase (server-side)
        app(AnalyticsService::class)->trackPurchase($order, request(), $fbPurchaseEventId);

        return view('checkout.success', compact('order', 'fbPurchaseEventId'));
    }

    public function failed(): View
    {
        return view('checkout.failed');
    }

    /**
     * Create a pending order + Stripe hosted Checkout Session, then return the Stripe
     * URL for the browser to redirect to. Payment is confirmed later by the webhook
     * and/or the success page (see StripeOrderService::confirm) — never here.
     *
     * NOTE: pricing below must stay in sync with process() (the COD path).
     */
    public function createStripeSession(Request $request): JsonResponse
    {
        $this->logActivity('payment_initiated', ['method' => 'stripe'], $request);
        $isGuest = !auth()->check();

        $rules = [
            'same_billing_address' => ['nullable', 'boolean'],
            'payment_method' => ['required', 'string', 'in:stripe'],
            'notes' => ['nullable', 'string', 'max:500'],
            'delivery_method' => ['nullable', 'string', 'in:collection'],
            // Collection only — we just capture the customer's name.
            'guest_name' => ['required', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        // Delivery window validation (mirrors process())
        // Collection only — delivery was withdrawn, so there is never a fee,
        // no minimum order and no delivery window to police.
        $isDelivery = false;
        if ($isDelivery) {
            $ukNow = now('Europe/London');
            if ((int) $ukNow->format('N') === 7) {
                return response()->json(['error' => 'No delivery on Sundays. Please choose Collection.'], 422);
            }
            $hour = (int) $ukNow->format('G');
            if ($hour < 10 || $hour >= 16) {
                return response()->json(['error' => 'Delivery available Mon–Sat 10 AM – 4 PM only.'], 422);
            }
        }

        $cart = $this->getCart(['items.product', 'items.variant', 'coupon']);
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty.'], 422);
        }

        // Re-validate stock (final reservation happens at confirmation; fail fast here)
        foreach ($cart->items as $item) {
            $available = $item->variant_id ? $item->variant->stock_quantity : $item->product->stock_quantity;
            if ($available < $item->quantity) {
                return response()->json(['error' => "\"{$item->product->name}\" only has {$available} item(s) in stock."], 422);
            }
        }

        // ── Pricing (must mirror process()) ──
        $navratriDiscount = 0;
        if (Setting::get('navratri_offer_active', '1') === '1') {
            $navratriDiscount = round(($cart->subtotal - $cart->discount) * 0.05, 2);
        }
        $totalDiscount = $cart->discount + $navratriDiscount;

        $loyaltyPointsUsed = 0;
        $loyaltyDiscount = 0;
        if (!$isGuest && $request->boolean('use_loyalty_points') && (bool) Setting::get('loyalty_enabled', true)) {
            $user = auth()->user();
            $pointsAvailable = $user->loyalty_points_balance ?? 0;
            $redeemRate = (float) Setting::get('loyalty_redeem_rate', 0.25);
            $maxDiscount = $pointsAvailable * $redeemRate;
            $loyaltyDiscount = min($maxDiscount, $cart->subtotal - $totalDiscount);
            $loyaltyPointsUsed = (int) ceil($loyaltyDiscount / $redeemRate);
            $totalDiscount += $loyaltyDiscount;
        }

        $shippingFee = 0;
        if ($isDelivery) {
            $deliveryMinOrder = (float) Setting::get('delivery_min_order', 25);
            if (($cart->subtotal - $totalDiscount) < $deliveryMinOrder) {
                return response()->json(['error' => 'Minimum order for delivery is £' . number_format($deliveryMinOrder, 2) . '.'], 422);
            }
            $shippingFee = (float) Setting::get('delivery_fee', 5);
        }

        $finalTotal = max(0, $cart->subtotal - $totalDiscount + $shippingFee);

        if ($finalTotal < 1) {
            return response()->json(['error' => 'Order total is too low for online payment. Please choose another method.'], 422);
        }

        // ── Address snapshot — collection only, so we keep just the name ──
        $customerName = $validated['guest_name'];
        $shippingSnapshot = [
            'name' => $customerName,
            'phone' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'country' => '',
        ];
        $billingSnapshot = $shippingSnapshot;
        $shippingAddressId = null;
        $billingAddressId = null;

        // ── Affiliate resolution ──
        $affiliateId = null;
        $affiliateRefCode = null;
        $refCode = session('affiliate_ref') ?? request()->cookie(config('affiliate.cookie_name', 'justburgers_ref'));
        if ($refCode) {
            $affiliate = Affiliate::where('referral_code', $refCode)->where('status', 'approved')->first();
            if ($affiliate) {
                $affiliateId = $affiliate->id;
                $affiliateRefCode = $refCode;
            }
        }

        $contactEmail = $isGuest ? ($validated['guest_email'] ?? null) : (auth()->user()->email ?? null);

        // ── Create the pending order (stock decrement + cart clear are deferred to
        //    confirmation, so abandoned Stripe sessions never lock stock) ──
        $metadata = [
            'payment_method' => 'stripe',
            'cart_id' => $cart->id,
        ];
        if ($navratriDiscount > 0) {
            $metadata['navratri_discount'] = $navratriDiscount;
        }
        if ($loyaltyPointsUsed > 0) {
            $metadata['loyalty_points_used'] = $loyaltyPointsUsed;
            $metadata['loyalty_discount'] = $loyaltyDiscount;
        }
        if ($affiliateRefCode) {
            $metadata['affiliate_referral_code'] = $affiliateRefCode;
        }

        $order = DB::transaction(function () use ($cart, $shippingSnapshot, $billingSnapshot, $shippingAddressId, $billingAddressId, $validated, $isGuest, $finalTotal, $totalDiscount, $shippingFee, $affiliateId, $affiliateRefCode, $metadata) {
            $order = Order::create([
                'user_id' => $isGuest ? null : auth()->id(),
                'guest_email' => $validated['guest_email'] ?? null,
                'guest_name' => $validated['guest_name'] ?? null,
                'guest_phone' => $validated['guest_phone'] ?? null,
                // Same as the direct path above: the kitchen starts on it now.
                'status' => Order::STATUS_PREPARING,
                'preparing_at' => now(),
                'payment_status' => 'pending',
                'subtotal' => $cart->subtotal,
                'discount' => $totalDiscount,
                'shipping_cost' => $shippingFee,
                'tax' => 0,
                'total' => $finalTotal,
                'paid_amount' => 0,
                'currency' => 'GBP',
                'coupon_id' => $cart->coupon_id,
                'affiliate_id' => $affiliateId,
                'affiliate_referral_code' => $affiliateRefCode,
                'shipping_address_id' => $shippingAddressId,
                'billing_address_id' => $billingAddressId,
                'shipping_address_snapshot' => $shippingSnapshot,
                'billing_address_snapshot' => $billingSnapshot,
                'notes' => $validated['notes'] ?? null,
                'metadata' => $metadata,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'seller_id' => $item->product->seller_id,
                    'product_name' => $item->product->name,
                    'sku' => $item->product->sku ?? '',
                    'variant_name' => $item->variant?->attributeValues->pluck('value')->join(' / '),
                    'quantity' => $item->quantity,
                    'mrp' => $item->product->mrp ?? $item->price,
                    'price' => $item->price,
                    'tax' => 0,
                    'discount' => 0,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            return $order;
        });

        // ── Create the Stripe Checkout Session ──
        $siteName = Setting::get('site_name', config('app.name'));
        $params = [
            'mode' => 'payment',
            'success_url' => route('checkout.success', $order) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.index'),
            'client_reference_id' => (string) $order->id,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => ['name' => $siteName . ' — Order #' . $order->order_number],
                    'unit_amount' => (int) round($finalTotal * 100), // GBP → pence
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
            ],
            'payment_intent_data' => [
                'metadata' => ['order_id' => (string) $order->id],
            ],
        ];
        if ($contactEmail) {
            $params['customer_email'] = $contactEmail;
        }

        try {
            $session = app(StripeService::class)->createCheckoutSession($params);
        } catch (\Throwable $e) {
            Log::error('Stripe session creation failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            $this->logActivity('payment_error', ['stage' => 'stripe_session_create', 'error' => $e->getMessage()], $request);
            // Roll back the pending order — no stock/cart side-effects were applied yet.
            $order->items()->delete();
            $order->delete();
            return response()->json(['error' => 'Payment could not be started. Please try again.'], 502);
        }

        // Store the session id so the success page can confirm independently of the webhook.
        $order->update([
            'metadata' => array_merge($order->metadata ?? [], ['stripe_session_id' => $session['id']]),
        ]);

        // Guests are authorised on the success page via this session key.
        if ($isGuest) {
            session()->put('guest_order_id', $order->id);
        }

        // Facebook CAPI: AddPaymentInfo
        $fbEventId = AnalyticsService::generateEventId('api');
        app(AnalyticsService::class)->trackAddPaymentInfo($finalTotal, 'stripe', $request, $fbEventId);

        return response()->json([
            'url' => $session['url'],
            'order_id' => $order->id,
        ]);
    }

    private function getCart(array $with = ['items.product', 'items.variant']): ?Cart
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->with($with)->first();
        }

        $sessionId = session()->getId();
        return Cart::where('session_id', $sessionId)->whereNull('user_id')->with($with)->first();
    }

    private function recordAbandonedCheckout(Cart $cart, string $step = 'checkout'): void
    {
        AbandonedCheckout::updateOrCreate(
            ['cart_id' => $cart->id],
            [
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'cart_total' => $cart->subtotal - $cart->discount,
                'items_count' => $cart->items->count(),
                'step' => $step,
                'cart_snapshot' => $cart->items->map(fn ($item) => [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ])->toArray(),
            ]
        );
    }

    private function markAbandonedRecovered(Cart $cart, Order $order): void
    {
        AbandonedCheckout::where('cart_id', $cart->id)->update([
            'recovered' => true,
            'order_id' => $order->id,
            'recovered_at' => now(),
        ]);
    }

    /**
     * Capture guest email/phone for abandoned checkout recovery (AJAX).
     */
    public function captureAbandoned(Request $request): JsonResponse
    {
        $cart = $this->getCart();
        if (!$cart) {
            return response()->json(['ok' => false], 404);
        }

        $email = $request->input('email');
        $phone = $request->input('phone');
        $name = $request->input('name');

        if (!$email && !$phone) {
            return response()->json(['ok' => false], 422);
        }

        AbandonedCheckout::updateOrCreate(
            ['cart_id' => $cart->id],
            array_filter([
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'email' => $email,
                'phone' => $phone,
                'name' => $name,
                'cart_total' => $cart->subtotal - $cart->discount,
                'items_count' => $cart->items->count(),
                'step' => 'contact_captured',
                'cart_snapshot' => $cart->items->map(fn ($item) => [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ])->toArray(),
            ])
        );

        return response()->json(['ok' => true]);
    }

    /**
     * Auto-create user account for guest orders and send credentials via email + WhatsApp.
     */
    private function createAccountForGuest(Order $order, array $validated): void
    {
        $email = $validated['guest_email'] ?? null;
        $phone = $validated['guest_phone'] ?? null;
        $name = $validated['guest_name'] ?? 'Customer';

        if (!$email) {
            return;
        }

        // Check if account already exists
        if (\App\Models\User::where('email', $email)->exists()) {
            return;
        }

        try {
            $password = strtolower(substr(str_replace(' ', '', $name), 0, 4)) . rand(1000, 9999);
            $nameParts = explode(' ', $name, 2);

            $user = \App\Models\User::create([
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $email,
                'phone' => $phone ? preg_replace('/\D/', '', $phone) : null,
                'password' => bcrypt($password),
                'email_verified_at' => now(),
            ]);

            // Link order to new user
            $order->update(['user_id' => $user->id]);

            // Send credentials via email
            \Illuminate\Support\Facades\Mail::send([], [], function ($m) use ($email, $name, $password, $order) {
                $m->to($email)
                  ->from(config('mail.from.address', 'justburgersplus@gmail.com'), \App\Models\Setting::get('site_name', config('app.name')))
                  ->subject('Your ' . \App\Models\Setting::get('site_name', config('app.name')) . ' Account is Ready!')
                  ->html("<div style='font-family:sans-serif;max-width:450px;margin:0 auto;padding:20px;'>
                    <h2 style='color:#205258;'>Welcome to " . \App\Models\Setting::get('site_name', config('app.name')) . ", {$name}!</h2>
                    <p style='font-size:14px;color:#333;'>Your account has been created with your recent order #{$order->order_number}.</p>
                    <div style='background:#f5f5f5;border-radius:8px;padding:15px;margin:15px 0;'>
                        <p style='font-size:13px;color:#555;margin:0 0 5px;'><strong>Email:</strong> {$email}</p>
                        <p style='font-size:13px;color:#555;margin:0 0 5px;'><strong>Password:</strong> {$password}</p>
                    </div>
                    <p style='font-size:13px;color:#333;'>You can also login using OTP via WhatsApp — no password needed!</p>
                    <a href='" . url('/login') . "' style='display:inline-block;background:#205258;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:bold;margin-top:10px;'>Login Now</a>
                    <p style='font-size:11px;color:#999;margin-top:20px;'>We recommend changing your password after first login.</p>
                  </div>");
            });

            // Send credentials via WhatsApp
            if ($phone) {
                $token = config('services.meta.page_access_token');
                $phoneId = config('services.meta.whatsapp_phone_number_id');
                if ($token && $phoneId) {
                    $cleanPhone = preg_replace('/\D/', '', $phone);
                    if (!str_starts_with($cleanPhone, '44') && strlen($cleanPhone) === 11 && str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '44' . substr($cleanPhone, 1);
                    }
                    Http::withToken($token)->post("https://graph.facebook.com/v21.0/{$phoneId}/messages", [
                        'messaging_product' => 'whatsapp',
                        'to' => $cleanPhone,
                        'type' => 'text',
                        'text' => [
                            'body' => "Hi {$name}! Your " . \App\Models\Setting::get('site_name', config('app.name')) . " account is ready.\n\nEmail: {$email}\nPassword: {$password}\n\nYou can also login with OTP — just enter your phone number on the login page.\n\nLogin: " . url('/login'),
                        ],
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Guest account creation failed', ['email' => $email, 'error' => $e->getMessage()]);
        }
    }
}

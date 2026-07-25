<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\DiscountRule;
use App\Models\PosHeldBill;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get the current cart data.
     */
    public function data(Request $request): JsonResponse
    {
        return response()->json([
            'cart' => $this->getCartResponse($request),
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'quantity'    => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::with('category')->find($validated['product_id']);

        if (! $product || $product->status !== 'approved' || ! $product->is_active) {
            return response()->json(['message' => 'Product is not available.'], 422);
        }

        $variant = null;
        $price = (float) $product->price;
        $stock = (int) $product->stock_quantity;
        $variantName = null;

        if (! empty($validated['variant_id'])) {
            $variant = ProductVariant::where('id', $validated['variant_id'])
                ->where('product_id', $product->id)
                ->first();

            if (! $variant) {
                return response()->json(['message' => 'Variant not found.'], 422);
            }

            $price = (float) ($variant->price ?? $product->price);
            $stock = (int) $variant->stock_quantity;
            $variantName = $variant->name;
        }

        $qty = $validated['quantity'] ?? 1;

        // Check stock
        if ($stock < $qty) {
            return response()->json(['message' => "Only {$stock} in stock."], 422);
        }

        $cart = $this->getCart($request);
        $itemKey = $product->id . '-' . ($variant?->id ?? 0);

        // Check if already in cart
        $existingIndex = null;
        foreach ($cart['items'] as $i => $item) {
            if ($item['key'] === $itemKey) {
                $existingIndex = $i;
                break;
            }
        }

        if ($existingIndex !== null) {
            $newQty = $cart['items'][$existingIndex]['quantity'] + $qty;
            if ($newQty > $stock) {
                return response()->json(['message' => "Only {$stock} available. Already {$cart['items'][$existingIndex]['quantity']} in cart."], 422);
            }
            $cart['items'][$existingIndex]['quantity'] = $newQty;
            $cart['items'][$existingIndex]['total'] = round($price * $newQty, 2);
        } else {
            $cart['items'][] = [
                'key'            => $itemKey,
                'cart_item_id'   => Str::uuid()->toString(),
                'product_id'    => $product->id,
                'variant_id'    => $variant?->id,
                'product_name'  => $product->name,
                'variant_name'  => $variantName,
                'sku'           => $variant?->sku ?? $product->sku,
                'barcode'       => $variant?->barcode ?? $product->barcode,
                'price'         => $price,
                'mrp'           => (float) ($product->mrp ?? $price),
                'cost_price'    => (float) ($product->cost_price ?? 0),
                'tax_rate'      => (float) ($product->tax_rate ?? 0),
                'hsn_code'      => $product->hsn_code,
                'quantity'      => $qty,
                'discount'      => 0,
                'total'         => round($price * $qty, 2),
                'stock'         => $stock,
            ];
        }

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, string $item): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cart = $this->getCart($request);

        $index = $this->findItemIndex($cart, $item);
        if ($index === null) {
            return response()->json(['message' => 'Item not found in cart.'], 404);
        }

        $cartItem = &$cart['items'][$index];

        // Re-check stock
        if ($validated['quantity'] > $cartItem['stock']) {
            return response()->json(['message' => "Only {$cartItem['stock']} in stock."], 422);
        }

        $cartItem['quantity'] = $validated['quantity'];
        $cartItem['total'] = round($cartItem['price'] * $cartItem['quantity'], 2);

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request, string $item): JsonResponse
    {
        $cart = $this->getCart($request);

        $index = $this->findItemIndex($cart, $item);
        if ($index === null) {
            return response()->json(['message' => 'Item not found in cart.'], 404);
        }

        array_splice($cart['items'], $index, 1);

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(Request $request): JsonResponse
    {
        $cart = $this->emptyCart();
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * List active discount rules available for the manual-discount chips.
     */
    public function discountRules(): JsonResponse
    {
        $rules = DiscountRule::where('is_active', true)
            ->orderBy('position')
            ->get()
            ->map(fn (DiscountRule $rule) => [
                'id'             => $rule->id,
                'label'          => $rule->label,
                'percent'        => (float) $rule->percent,
                'max_cart_value' => $rule->max_cart_value !== null ? (float) $rule->max_cart_value : null,
                'requires_pin'   => $rule->requires_pin,
            ]);

        return response()->json(['rules' => $rules]);
    }

    /**
     * Apply a manual discount to the cart — either a free-form percentage/fixed
     * value, or a preset DiscountRule (which may require manager PIN authorization).
     */
    public function applyDiscount(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type'         => ['required', 'in:percentage,fixed'],
            'value'        => ['required', 'numeric', 'min:0'],
            'reason'       => ['nullable', 'string', 'max:255'],
            'rule_id'      => ['nullable', 'integer', 'exists:discount_rules,id'],
            'manager_pin'  => ['nullable', 'string', 'min:4', 'max:6'],
        ]);

        $cart = $this->getCart($request);
        $authorizedBy = null;
        $label = $validated['reason'] ?? '';
        $ruleId = null;
        $requiresPin = false;

        if (! empty($validated['rule_id'])) {
            $rule = DiscountRule::findOrFail($validated['rule_id']);

            if (! $rule->isApplicable($cart['subtotal'])) {
                return response()->json([
                    'message' => $rule->max_cart_value !== null
                        ? "This discount only applies to carts up to £" . number_format($rule->max_cart_value, 2) . '.'
                        : 'This discount rule is not currently active.',
                ], 422);
            }

            if ($rule->requires_pin) {
                $storeId = $request->session()->get('pos_store_id');
                $manager = $validated['manager_pin']
                    ? Staff::findByPin($storeId, $validated['manager_pin'], ['manager', 'supervisor'])
                    : null;

                if (! $manager) {
                    return response()->json(['message' => 'Manager PIN required to apply this discount.'], 401);
                }

                $authorizedBy = $manager->id;
            }

            $ruleId = $rule->id;
            $requiresPin = $rule->requires_pin;
            $label = $rule->label;
        }

        $cart['manual_discount'] = [
            'type'          => $validated['type'],
            'value'         => (float) $validated['value'],
            'reason'        => $label,
            'rule_id'       => $ruleId,
            'requires_pin'  => $requiresPin,
            'authorized_by' => $authorizedBy,
        ];

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        if ($authorizedBy) {
            AuditController::log($request, 'discount_authorized', 'pos_cart', null, [
                'authorized_by' => $authorizedBy,
                'description'   => "Applied '{$label}' discount requiring manager authorization",
            ]);
        }

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Remove the applied manual discount.
     */
    public function removeDiscount(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);
        $cart['manual_discount'] = null;

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Apply a coupon code to the cart.
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $coupon = Coupon::where('code', $validated['code'])
            ->where('is_active', true)
            ->first();

        if (! $coupon) {
            return response()->json(['message' => 'Invalid coupon code.'], 422);
        }

        // Check validity dates
        if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
            return response()->json(['message' => 'This coupon is not active yet.'], 422);
        }
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json(['message' => 'This coupon has expired.'], 422);
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit) {
            return response()->json(['message' => 'This coupon has reached its usage limit.'], 422);
        }

        $cart = $this->getCart($request);

        // Check minimum order
        if ($coupon->min_order_amount && $cart['subtotal'] < $coupon->min_order_amount) {
            return response()->json([
                'message' => 'Minimum order of £' . number_format($coupon->min_order_amount, 2) . ' required.',
            ], 422);
        }

        // Calculate coupon discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = round($cart['subtotal'] * $coupon->value / 100, 2);
            if ($coupon->max_discount) {
                $discount = min($discount, $coupon->max_discount);
            }
        } elseif ($coupon->type === 'fixed') {
            $discount = min($coupon->value, $cart['subtotal']);
        }

        $cart['coupon'] = [
            'id'           => $coupon->id,
            'code'         => $coupon->code,
            'type'         => $coupon->type,
            'value'        => (float) $coupon->value,
            'max_discount' => $coupon->max_discount ? (float) $coupon->max_discount : null,
            'discount'     => round($discount, 2),
        ];

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Remove the applied coupon.
     */
    public function removeCoupon(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);
        $cart['coupon'] = null;

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Attach a customer to the cart.
     */
    public function attachCustomer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['nullable', 'integer'],
        ]);

        $cart = $this->getCart($request);

        if ($validated['customer_id']) {
            $customer = \App\Models\User::find($validated['customer_id']);
            $cart['customer'] = $customer ? [
                'id'    => $customer->id,
                'name'  => $customer->first_name
                    ? $customer->first_name . ' ' . ($customer->last_name ?? '')
                    : $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
            ] : null;
        } else {
            $cart['customer'] = null;
        }

        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * List active staff at the current store, for the salesperson dropdown.
     */
    public function activeStaff(Request $request): JsonResponse
    {
        $storeId = $request->session()->get('pos_store_id');

        $staff = Staff::with('user')
            ->where('store_id', $storeId)
            ->where('is_active', true)
            ->get()
            ->map(fn (Staff $s) => [
                'id'   => $s->id,
                'name' => $s->user->first_name ?? $s->user->name ?? 'Staff',
                'role' => $s->role,
            ]);

        return response()->json(['staff' => $staff]);
    }

    /**
     * Set (or clear) the salesperson credited for the current cart's sale.
     */
    public function setSalesperson(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'salesperson_id' => ['nullable', 'integer', 'exists:staff,id'],
        ]);

        $cart = $this->getCart($request);
        $cart['salesperson_id'] = $validated['salesperson_id'] ?? null;
        $this->saveCart($request, $cart);

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    // ═══════ HELD BILLS ═══════

    /**
     * Get list of held bills.
     */
    public function heldBills(Request $request): JsonResponse
    {
        $storeId = $request->session()->get('pos_store_id');

        $bills = PosHeldBill::where('store_id', $storeId)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn ($bill) => [
                'id'               => $bill->id,
                'reference'        => $bill->note,
                'items_count'      => count($bill->items ?? []),
                'total'            => $bill->total,
                'customer_name'    => $bill->customer?->name,
                'created_at_human' => $bill->created_at->diffForHumans(),
            ]);

        return response()->json(['bills' => $bills]);
    }

    /**
     * Hold (park) the current cart.
     */
    public function hold(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $cart = $this->getCart($request);

        if (empty($cart['items'])) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        PosHeldBill::create([
            'store_id'       => $request->session()->get('pos_store_id'),
            'register_id'    => $request->session()->get('pos_register_id'),
            'staff_id'       => $request->session()->get('pos_staff_id'),
            'salesperson_id' => $cart['salesperson_id'] ?? null,
            'customer_id'    => $cart['customer']['id'] ?? null,
            'items'          => $cart['items'],
            'discount_data'  => $cart['coupon'] ?? $cart['manual_discount'] ?? null,
            'note'           => $validated['reference'],
            'subtotal'       => $cart['subtotal'],
            'tax'            => $cart['tax'],
            'total'          => $cart['total'],
        ]);

        // Clear the cart
        $this->saveCart($request, $this->emptyCart());

        return response()->json(['success' => true]);
    }

    /**
     * Resume a held bill back into the cart.
     */
    public function resume(Request $request, int $bill): JsonResponse
    {
        $heldBill = PosHeldBill::where('id', $bill)
            ->where('store_id', $request->session()->get('pos_store_id'))
            ->firstOrFail();

        $cart = [
            'items'           => $heldBill->items ?? [],
            'customer'        => $heldBill->customer ? [
                'id'    => $heldBill->customer->id,
                'name'  => $heldBill->customer->name,
                'phone' => $heldBill->customer->phone ?? '',
                'email' => $heldBill->customer->email ?? '',
            ] : null,
            'salesperson_id'  => $heldBill->salesperson_id,
            'coupon'          => null,
            'manual_discount' => null,
            'subtotal'        => 0,
            'discount'        => 0,
            'tax'             => 0,
            'total'           => 0,
        ];

        // Restore discount data if it was a coupon
        if ($heldBill->discount_data && isset($heldBill->discount_data['code'])) {
            $cart['coupon'] = $heldBill->discount_data;
        } elseif ($heldBill->discount_data) {
            $cart['manual_discount'] = $heldBill->discount_data;
        }

        $this->recalculate($cart);
        $this->saveCart($request, $cart);

        // Delete the held bill
        $heldBill->delete();

        return response()->json([
            'cart' => $this->formatCartResponse($cart),
        ]);
    }

    /**
     * Delete a held bill.
     */
    public function deleteHeld(Request $request, int $bill): JsonResponse
    {
        PosHeldBill::where('id', $bill)
            ->where('store_id', $request->session()->get('pos_store_id'))
            ->delete();

        return response()->json(['success' => true]);
    }

    // ═══════ CART HELPERS ═══════

    private function getCart(Request $request): array
    {
        return $request->session()->get('pos_cart', $this->emptyCart());
    }

    private function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('pos_cart', $cart);
    }

    private function emptyCart(): array
    {
        return [
            'items'           => [],
            'customer'        => null,
            'salesperson_id'  => null,
            'coupon'          => null,
            'manual_discount' => null,
            'subtotal'        => 0,
            'discount'        => 0,
            'tax'             => 0,
            'total'           => 0,
        ];
    }

    private function findItemIndex(array &$cart, string $cartItemId): ?int
    {
        foreach ($cart['items'] as $i => $item) {
            if ($item['cart_item_id'] === $cartItemId) {
                return $i;
            }
        }
        return null;
    }

    private function recalculate(array &$cart): void
    {
        $subtotal = 0;
        $totalTax = 0;
        $totalDiscount = 0;

        foreach ($cart['items'] as &$item) {
            $lineTotal = round($item['price'] * $item['quantity'], 2);
            $item['total'] = $lineTotal;
            $subtotal += $lineTotal;

            // Calculate tax per item (GST inclusive price → extract tax)
            $item['tax_amount'] = 0;
            if ($item['tax_rate'] > 0) {
                $taxAmount = round($lineTotal * $item['tax_rate'] / (100 + $item['tax_rate']), 2);
                $item['tax_amount'] = $taxAmount;
                $totalTax += $taxAmount;
            }
        }

        // Apply coupon discount
        $couponDiscount = 0;
        if ($cart['coupon']) {
            if ($cart['coupon']['type'] === 'percentage') {
                $couponDiscount = round($subtotal * $cart['coupon']['value'] / 100, 2);
                if (! empty($cart['coupon']['max_discount'])) {
                    $couponDiscount = min($couponDiscount, $cart['coupon']['max_discount']);
                }
            } elseif ($cart['coupon']['type'] === 'fixed') {
                $couponDiscount = min($cart['coupon']['value'], $subtotal);
            }
            $cart['coupon']['discount'] = round($couponDiscount, 2);
        }

        // Apply manual discount
        $manualDiscount = 0;
        if (! empty($cart['manual_discount'])) {
            if ($cart['manual_discount']['type'] === 'percentage') {
                $manualDiscount = round($subtotal * $cart['manual_discount']['value'] / 100, 2);
            } else {
                $manualDiscount = min($cart['manual_discount']['value'], $subtotal);
            }
            $cart['manual_discount']['discount'] = round($manualDiscount, 2);
        }

        $totalDiscount = round($couponDiscount + $manualDiscount, 2);

        $cart['subtotal'] = round($subtotal, 2);
        $cart['discount'] = $totalDiscount;
        $cart['tax'] = round($totalTax, 2);
        $cart['total'] = round(max(0, $subtotal - $totalDiscount), 2);
    }

    private function getCartResponse(Request $request): array
    {
        return $this->formatCartResponse($this->getCart($request));
    }

    private function formatCartResponse(array $cart): array
    {
        return [
            'items'           => array_values($cart['items']),
            'customer'        => $cart['customer'],
            'salesperson_id'  => $cart['salesperson_id'] ?? null,
            'coupon'          => $cart['coupon'],
            'manual_discount' => $cart['manual_discount'] ?? null,
            'subtotal'        => $cart['subtotal'],
            'discount'        => $cart['discount'],
            'tax'             => $cart['tax'],
            'total'           => $cart['total'],
        ];
    }
}

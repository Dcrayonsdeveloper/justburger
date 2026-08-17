<?php

namespace App\Listeners;

use App\Events\OrderDelivered;
use App\Events\OrderPlaced;
use App\Events\OrderShipped;
use App\Events\OrderStatusChanged;
use App\Events\RefundProcessed;
use App\Events\ReturnRequested;
use App\Mail\OrderConfirmation;
use App\Mail\OrderDelivered as OrderDeliveredMail;
use App\Mail\OrderShipped as OrderShippedMail;
use App\Mail\RefundProcessed as RefundProcessedMail;
use App\Mail\ReturnApproved;
use App\Models\Order;
use App\Models\Setting;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOrderNotification
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function handleOrderPlaced(OrderPlaced $event): void
    {
        $order = $event->order;
        $user = $order->user;

        // Email + in-app for registered users
        if ($user) {
            $this->notificationService->notify($user, 'order_placed', [
                'title' => 'Order Confirmed',
                'content' => "Your order #{$order->order_number} has been confirmed.",
                'order_id' => $order->id,
            ], new OrderConfirmation($order));
        }

        // WhatsApp to customer
        $customerPhone = $user?->phone ?? $order->guest_phone;
        $customerName = $user?->first_name ?? $order->guest_name ?? 'Customer';
        if ($customerPhone) {
            $this->sendWhatsApp(
                $customerPhone,
                "Hi {$customerName}! 🎉 Your " . \App\Models\Setting::get('site_name', config('app.name')) . " order #{$order->order_number} is confirmed!\n\n"
                . "Order Total: £" . number_format($order->total, 2) . "\n"
                . "Payment: " . ($order->payment_status === 'paid' ? '✅ Paid' : '💵 Pay on Collection') . "\n\n"
                . "Track your order: " . url("/track-order") . "\n\n"
                . "Thank you for ordering from " . \App\Models\Setting::get('site_name', config('app.name')) . "! 🍔"
            );
        }

        // WhatsApp to admin
        $adminPhone = Setting::get('admin_whatsapp_phone', '447368998035');
        if ($adminPhone) {
            $itemsSummary = $order->items->map(fn($item) => "• {$item->product_name} x{$item->quantity} — £" . number_format($item->total, 2))->implode("\n");
            $address = $order->shipping_address_snapshot ?? [];
            $addressLine = ($address['address_line_1'] ?? '') . ', ' . ($address['city'] ?? '') . ' ' . ($address['postal_code'] ?? '');

            $this->sendWhatsApp(
                $adminPhone,
                "🔔 *NEW ORDER* #{$order->order_number}\n\n"
                . "Customer: {$customerName}\n"
                . "Phone: {$customerPhone}\n"
                . "Payment: " . ($order->payment_status === 'paid' ? 'Paid Online ✅' : 'Pay on Collection 💵') . "\n\n"
                . "Items:\n{$itemsSummary}\n\n"
                . "Total: *£" . number_format($order->total, 2) . "*\n"
                . "Deliver to: {$addressLine}\n\n"
                . "Manage: " . url("/admin/orders/{$order->id}")
            );
        }

        // In-app bell notification for admin/staff users
        $this->notifyAdmins(
            'admin_new_order',
            "New order #{$order->order_number}",
            $customerName . ' placed an order · £' . number_format($order->total, 2)
                . ' · ' . ($order->payment_status === 'paid' ? 'Paid online' : 'Pay on collection'),
            ['order_id' => $order->id, 'url' => "/admin/orders/{$order->id}"]
        );
    }

    public function handleOrderShipped(OrderShipped $event): void
    {
        $order = $event->order;
        $user = $order->user;

        if ($user) {
            $this->notificationService->notify($user, 'order_shipped', [
                'title' => 'Order On Its Way',
                'content' => "Your order #{$order->order_number} is out for delivery.",
                'order_id' => $order->id,
                'tracking_number' => $event->trackingNumber,
            ], new OrderShippedMail($order, $event->trackingNumber));
        }

        // WhatsApp to customer
        $customerPhone = $user?->phone ?? $order->guest_phone;
        $customerName = $user?->first_name ?? $order->guest_name ?? 'Customer';
        if ($customerPhone) {
            $this->sendWhatsApp(
                $customerPhone,
                "Hi {$customerName}! 🚗 Your " . \App\Models\Setting::get('site_name', config('app.name')) . " order #{$order->order_number} is out for delivery!\n\n"
                . "Track: " . url("/track-order") . "\n\n"
                . "Thank you for ordering from " . \App\Models\Setting::get('site_name', config('app.name')) . "! 🍔"
            );
        }
    }

    public function handleOrderDelivered(OrderDelivered $event): void
    {
        $order = $event->order;
        $user = $order->user;

        if ($user) {
            $this->notificationService->notify($user, 'order_delivered', [
                'title' => 'Order Delivered',
                'content' => "Your order #{$order->order_number} has been delivered. Enjoy your meal!",
                'order_id' => $order->id,
            ], new OrderDeliveredMail($order));
        }

        // WhatsApp to customer
        $customerPhone = $user?->phone ?? $order->guest_phone;
        $customerName = $user?->first_name ?? $order->guest_name ?? 'Customer';
        if ($customerPhone) {
            $this->sendWhatsApp(
                $customerPhone,
                "Hi {$customerName}! ✅ Your " . \App\Models\Setting::get('site_name', config('app.name')) . " order #{$order->order_number} has been delivered!\n\n"
                . "Enjoy your meal! If you need any help, reply here or call us.\n\n"
                . "Thank you for choosing " . \App\Models\Setting::get('site_name', config('app.name')) . "! 🍔"
            );
        }
    }

    public function handleOrderStatusChanged(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $user = $order->user;
        if (! $user) {
            return;
        }

        if ($event->newStatus === 'cancelled') {
            $this->notificationService->notifyInApp($user, 'order_cancelled',
                'Order Cancelled',
                "Your order #{$order->order_number} has been cancelled.",
                ['order_id' => $order->id]
            );
        }
    }

    public function handleReturnRequested(ReturnRequested $event): void
    {
        $return = $event->return;
        $user = $return->order?->user;
        if (! $user) {
            return;
        }

        if ($return->status === 'approved') {
            $this->notificationService->notify($user, 'return_approved', [
                'title' => 'Return Approved',
                'content' => "Your return request #{$return->return_number} has been approved.",
                'return_id' => $return->id,
            ], new ReturnApproved($return));
        } else {
            $this->notificationService->notifyInApp($user, 'return_' . $return->status,
                'Return Update',
                "Your return request #{$return->return_number} status: {$return->status}.",
                ['return_id' => $return->id]
            );
        }
    }

    public function handleRefundProcessed(RefundProcessed $event): void
    {
        $return = $event->return;
        $user = $return->order?->user;
        if (! $user) {
            return;
        }

        $this->notificationService->notify($user, 'refund_processed', [
            'title' => 'Refund Processed',
            'content' => 'Your refund of ' . format_price($event->amount) . ' has been processed.',
            'return_id' => $return->id,
            'amount' => $event->amount,
        ], new RefundProcessedMail($return, $event->amount));
    }

    /**
     * Create an in-app bell notification for every admin/staff user.
     * Best-effort — a failure here must never break order processing.
     */
    private function notifyAdmins(string $type, string $title, string $content, array $data = []): void
    {
        try {
            $admins = \App\Models\User::where('role', 'admin')
                ->orWhere('role', 'staff')
                ->orWhereHas('admin')
                ->orWhereHas('staff')
                ->get();

            foreach ($admins as $admin) {
                $this->notificationService->notifyInApp($admin, $type, $title, $content, $data);
            }
        } catch (\Throwable $e) {
            Log::warning('Admin in-app notification failed: ' . $e->getMessage(), ['type' => $type]);
        }
    }

    /**
     * Send WhatsApp message via Meta Cloud API.
     */
    private function sendWhatsApp(string $phone, string $message): void
    {
        $token = config('services.meta.page_access_token');
        $phoneNumberId = config('services.meta.whatsapp_phone_number_id');

        if (empty($token) || empty($phoneNumberId)) {
            return;
        }

        // Clean phone: ensure 44 prefix for UK numbers
        $cleanPhone = preg_replace('/\D/', '', $phone);
        if (!str_starts_with($cleanPhone, '44') && strlen($cleanPhone) === 11 && str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '44' . substr($cleanPhone, 1);
        }

        try {
            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $cleanPhone,
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);

            if ($response->failed()) {
                Log::warning('WhatsApp order notification failed', [
                    'phone' => $cleanPhone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('WhatsApp order notification error', [
                'phone' => $cleanPhone,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

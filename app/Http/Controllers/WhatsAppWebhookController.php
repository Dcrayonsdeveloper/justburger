<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Verify webhook (GET) - Meta sends this to verify your endpoint.
     */
    public function verify(Request $request): Response
    {
        $verifyToken = config('services.whatsapp.verify_token', 'justburgers_whatsapp_verify_2026');
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token === $verifyToken) {
            Log::info('WhatsApp webhook verified successfully');
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        Log::warning('WhatsApp webhook verification failed', [
            'mode' => $mode,
            'token' => $token,
        ]);

        return response('Forbidden', 403);
    }

    /**
     * Handle incoming webhook events (POST).
     */
    public function handle(Request $request): Response
    {
        $payload = $request->all();

        Log::info('WhatsApp webhook received', ['payload' => $payload]);

        // Process messages
        $entries = $payload['entry'] ?? [];
        foreach ($entries as $entry) {
            $changes = $entry['changes'] ?? [];
            foreach ($changes as $change) {
                $value = $change['value'] ?? [];
                $messages = $value['messages'] ?? [];

                foreach ($messages as $message) {
                    $this->processMessage($message, $value);
                }

                // Handle status updates (sent, delivered, read)
                $statuses = $value['statuses'] ?? [];
                foreach ($statuses as $status) {
                    Log::info('WhatsApp message status', [
                        'id' => $status['id'] ?? '',
                        'status' => $status['status'] ?? '',
                        'recipient' => $status['recipient_id'] ?? '',
                    ]);
                }
            }
        }

        return response('OK', 200);
    }

    /**
     * Process an incoming WhatsApp message.
     */
    private function processMessage(array $message, array $value): void
    {
        $from = $message['from'] ?? '';
        $type = $message['type'] ?? '';
        $timestamp = $message['timestamp'] ?? '';
        $messageId = $message['id'] ?? '';

        // Get contact name
        $contacts = $value['contacts'] ?? [];
        $contactName = $contacts[0]['profile']['name'] ?? 'Unknown';

        Log::info('WhatsApp message received', [
            'from' => $from,
            'name' => $contactName,
            'type' => $type,
            'message_id' => $messageId,
        ]);

        // Handle text messages
        if ($type === 'text') {
            $text = $message['text']['body'] ?? '';
            Log::info("WhatsApp text from {$contactName} ({$from}): {$text}");

            // Auto-reply for common queries
            $this->autoReply($from, $text);
        }

        // Handle media (images, videos) — for video review cashback offer
        if (in_array($type, ['image', 'video'])) {
            $mediaId = $message[$type]['id'] ?? '';
            $caption = $message[$type]['caption'] ?? '';
            Log::info("WhatsApp {$type} from {$contactName} ({$from})", [
                'media_id' => $mediaId,
                'caption' => $caption,
            ]);
        }
    }

    /**
     * Send auto-reply based on message content.
     */
    private function autoReply(string $to, string $text): void
    {
        $textLower = strtolower(trim($text));

        $reply = null;

        $siteName = \App\Models\Setting::get('site_name', config('app.name'));
        $siteUrl = url('/');

        if (in_array($textLower, ['hi', 'hello', 'hey', 'hii'])) {
            $reply = "Hello! 👋 Welcome to {$siteName}! 🍔\n\nHow can we help you today?\n\n1️⃣ Track my order\n2️⃣ View our menu\n3️⃣ Opening hours\n4️⃣ Talk to us\n\nReply with a number or type your query!";
        } elseif (str_contains($textLower, 'track') || str_contains($textLower, 'order')) {
            $reply = "📦 To track your order, please share your Order ID.\n\nYou can also track at: {$siteUrl}/track-order";
        } elseif (str_contains($textLower, 'hour') || str_contains($textLower, 'open') || str_contains($textLower, 'close') || str_contains($textLower, 'time')) {
            $hours = \App\Models\Setting::get('opening_hours', 'Mon–Sun: 11am – 11pm');
            $reply = "🕐 *Our Opening Hours*\n\n{$hours}\n\nOrder online: {$siteUrl}";
        } elseif (str_contains($textLower, 'menu') || str_contains($textLower, 'food') || str_contains($textLower, 'burger') || str_contains($textLower, 'order')) {
            $reply = "🍔 Browse our full menu at:\n👉 {$siteUrl}/menu\n\nOrder online for collection or delivery!";
        }

        if ($reply) {
            $this->sendMessage($to, $reply);
        }
    }

    /**
     * Send a WhatsApp message.
     */
    private function sendMessage(string $to, string $text): void
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_number_id');

        if (!$token || !$phoneId) {
            Log::warning('WhatsApp credentials not configured');
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->post("https://graph.facebook.com/v21.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => ['body' => $text],
                ]);

            if (!$response->successful()) {
                Log::error('WhatsApp send failed', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());
        }
    }
}

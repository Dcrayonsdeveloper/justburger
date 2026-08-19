<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:20|max:2000',
            'honeypot' => 'max:0', // anti-spam: must be empty
        ], [
            'rating.required' => 'Please select a star rating.',
            'rating.min' => 'Please select a star rating.',
            'guest_name.required' => 'Please enter your name.',
            'content.required' => 'Please write your review.',
            'content.min' => 'Your review must be at least 20 characters long.',
            'honeypot.max' => 'Something went wrong — please try again.',
        ]);

        // Guests no longer give an email, so the session is the only handle we
        // have left to stop the same visitor reviewing one product twice.
        $reviewed = $request->session()->get('reviewed_product_ids', []);

        if (in_array($product->id, $reviewed, true)) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'product_id' => $product->id,
            'guest_name' => $validated['guest_name'],
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'],
            'is_verified_purchase' => false,
            'is_approved' => false,
            'status' => 'pending',
        ]);

        $request->session()->put('reviewed_product_ids', [...$reviewed, $product->id]);

        return back()->with('success', 'Thank you for your review! It will be visible after moderation.');
    }
}

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
            'guest_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:20|max:2000',
            'honeypot' => 'max:0', // anti-spam: must be empty
        ], [
            'rating.required' => 'Please select a star rating.',
            'rating.min' => 'Please select a star rating.',
            'guest_name.required' => 'Please enter your name.',
            'guest_email.required' => 'Please enter your email address.',
            'guest_email.email' => 'Please enter a valid email address.',
            'content.required' => 'Please write your review.',
            'content.min' => 'Your review must be at least 20 characters long.',
            'honeypot.max' => 'Something went wrong — please try again.',
        ]);

        // Check for duplicate guest review on same product
        $exists = Review::where('product_id', $product->id)
            ->where('guest_email', $validated['guest_email'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'product_id' => $product->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'],
            'is_verified_purchase' => false,
            'is_approved' => false,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible after moderation.');
    }
}

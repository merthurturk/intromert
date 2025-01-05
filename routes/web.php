<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/newsletter/subscriptions', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email', 'max:255'],
        'honeypot' => ['sometimes', 'size:0'],
        'timestamp' => ['required', 'integer', 'min:' . now()->subMinutes(5)->timestamp],
    ]);

    try {
        // Rate limiting check
        if (RateLimiter::tooManyAttempts($request->ip(), 5)) {
            $seconds = RateLimiter::availableIn($request->ip());
            return response()->json([
                'message' => "Too many attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        // Increment the rate limiter
        RateLimiter::hit($request->ip());

        Http::withToken(config('services.lindris.key'))
            ->asJson()
            ->acceptJson()
            ->post('https://app.lindris.com/api/people', [
                'email' => $validated['email'],
                'tags' => ['source:intromert' => true, 'newsletter:intromert' => true],
            ]);

        return response()->json([
            'message' => 'Thanks! I\'m excited to share my journey with you.'
        ], 200);
    } catch (\Exception $e) {
        Log::error('Newsletter subscription failed', [
            'email' => $validated['email'],
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Subscription failed. Please try again later.'
        ], 500);
    }
});

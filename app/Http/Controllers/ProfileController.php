<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Get user's order statistics if customer
        $orderStats = null;
        if ($user->role === 'customer') {
            $orderStats = [
                'total_orders' => $user->orders()->count(),
                'total_spent' => $user->orders()->where('payment_status', 'paid')->sum('total_amount'),
                'recent_orders' => $user->orders()->latest()->take(5)->get()
            ];
        }
        
        return view('profile.edit', [
            'user' => $user,
            'orderStats' => $orderStats
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('profile.edit')->with('success', 'Password updated successfully!');
    }

    /**
     * Upload user avatar/profile picture.
     */
    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $avatarPath]);

        return Redirect::route('profile.edit')->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'order_notifications' => 'boolean',
            'marketing_emails' => 'boolean',
            'newsletter_subscription' => 'boolean',
            'timezone' => 'string|max:50',
            'language' => 'string|max:10',
        ]);

        $preferences = [
            'email_notifications' => $request->boolean('email_notifications'),
            'order_notifications' => $request->boolean('order_notifications'),
            'marketing_emails' => $request->boolean('marketing_emails'),
            'newsletter_subscription' => $request->boolean('newsletter_subscription'),
            'timezone' => $request->timezone ?? 'Asia/Karachi',
            'language' => $request->language ?? 'en',
        ];

        $request->user()->update(['preferences' => $preferences]);

        return Redirect::route('profile.edit')->with('success', 'Preferences updated successfully!');
    }

    /**
     * Display user's order history.
     */
    public function orders(Request $request): View
    {
        $user = $request->user();
        $orders = $user->orders()->with('orderItems.product')->latest()->paginate(10);
        
        return view('profile.orders', [
            'orders' => $orders
        ]);
    }

    /**
     * Display a single order details.
     */
    public function showOrder(Request $request, $orderId): View
    {
        $user = $request->user();
        $order = $user->orders()->with('orderItems.product')->findOrFail($orderId);
        
        return view('profile.order-detail', [
            'order' => $order
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

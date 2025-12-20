<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('product.category')->latest()->paginate(12);
        
        return view('profile.wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    /**
     * Add a product to wishlist.
     */
    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();
            
        if ($exists) {
            return redirect()->back()->with('error', 'Product is already in your wishlist!');
        }
        
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
        
        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    /**
     * Remove a product from wishlist.
     */
    public function destroy(Wishlist $wishlist)
    {
        // Ensure the wishlist item belongs to the authenticated user
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }
        
        $wishlist->delete();
        
        return redirect()->route('wishlist.index')->with('success', 'Product removed from wishlist!');
    }
}




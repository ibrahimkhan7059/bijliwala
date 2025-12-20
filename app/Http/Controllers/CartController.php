<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            // For guest users, use session
            $cartItems = session()->get('cart', []);
        }

        $total = 0;
        if (Auth::check()) {
            foreach ($cartItems as $item) {
                $total += $item->product->effective_price * $item->quantity;
            }
        } else {
            foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available!');
        }

        if (Auth::check()) {
            // For logged in users
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                if ($product->stock_quantity < $newQuantity) {
                    return back()->with('error', 'Cannot add more items. Stock limit reached!');
                }
                // Update price in case product price changed
                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $product->effective_price,
                ]);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $product->effective_price,
                ]);
            }
        } else {
            // For guest users, use session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->product_id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->effective_price,
                    'quantity' => $request->quantity,
                    'image' => $product->images[0] ?? null,
                ];
            }
            
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $product = $cartItem->product;
            
            if ($product->stock_quantity < $request->quantity) {
                return back()->with('error', 'Insufficient stock available!');
            }

            $cartItem->update(['quantity' => $request->quantity]);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('id', $id)
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count
     */
    public function count()
    {
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $count = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json(['count' => $count]);
    }
}

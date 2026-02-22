<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product', 'variation'])
                ->get();
        } else {
            // For guest users, use session
            $cartItems = session()->get('cart', []);
        }

        $total = 0;
        if (Auth::check()) {
            foreach ($cartItems as $item) {
                // Use the stored price from cart (which includes variation price)
                $total += $item->price * $item->quantity;
            }
        } else {
            foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        // Get delivery charges from settings
        $deliveryCharges = Cache::remember('delivery_charges', 3600, function() {
            $setting = DB::table('settings')->where('key', 'delivery_charges')->first();
            return $setting ? (float) $setting->value : 250;
        });
        
        $grandTotal = $total + $deliveryCharges;

        return view('cart.index', compact('cartItems', 'total', 'deliveryCharges', 'grandTotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1',
            'variation_id' => 'nullable|exists:product_variations,id',
        ]);

        $product   = Product::findOrFail($request->product_id);
        $variation = null;
        $price     = $product->effective_price;
        $stock     = $product->stock_quantity;
        $variationName = null;

        // If variation selected, use variation price & stock
        if ($request->variation_id) {
            $variation = ProductVariation::findOrFail($request->variation_id);
            $price     = $variation->price;
            $stock     = $variation->stock_quantity;
            $variationName = $variation->type . ': ' . $variation->name;
        }

        if ($stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available!');
        }

        if (Auth::check()) {
            // Unique cart item = product + variation combo
            $query = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->where('variation_id', $request->variation_id ?? null);

            $cartItem = $query->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                if ($stock < $newQuantity) {
                    return back()->with('error', 'Cannot add more items. Stock limit reached!');
                }
                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price'    => $price,
                ]);
            } else {
                Cart::create([
                    'user_id'        => Auth::id(),
                    'product_id'     => $request->product_id,
                    'variation_id'   => $request->variation_id ?? null,
                    'variation_name' => $variationName,
                    'quantity'       => $request->quantity,
                    'price'          => $price,
                ]);
            }
        } else {
            // Guest session cart — key includes variation
            $cart    = session()->get('cart', []);
            $cartKey = $request->product_id . '_' . ($request->variation_id ?? '0');

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $request->quantity;
            } else {
                $cart[$cartKey] = [
                    'product_id'     => $product->id,
                    'variation_id'   => $request->variation_id ?? null,
                    'variation_name' => $variationName,
                    'name'           => $product->name,
                    'price'          => $price,
                    'quantity'       => $request->quantity,
                    'image'          => $product->images[0] ?? null,
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
            $stock = $product->stock_quantity;
            
            // If variation is selected, use variation stock
            if ($cartItem->variation_id) {
                $variation = $cartItem->variation;
                $stock = $variation ? $variation->stock_quantity : $product->stock_quantity;
            }
            
            if ($stock < $request->quantity) {
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

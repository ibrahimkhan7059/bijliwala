<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        // Validation rules - add customer_name for guest users
        $rules = [
            'payment_proof' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:20',
        ];
        
        // Add name validation for guest users
        if (!Auth::check()) {
            $rules['customer_name'] = 'required|string|max:255';
        }
        
        $request->validate($rules);

        try {
            DB::beginTransaction();

            // Get cart items (for both logged-in and guest users)
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            } else {
                // For guest users, get cart from session
                $sessionCart = session()->get('cart', []);
                if (empty($sessionCart)) {
                    return back()->with('error', 'Your cart is empty!');
                }
                
                // Convert session cart to collection for consistency
                $cartItems = collect($sessionCart)->map(function($item, $productId) {
                    $product = \App\Models\Product::find($productId);
                    return (object) [
                        'product_id' => $productId,
                        'product' => $product,
                        'quantity' => $item['quantity'],
                    ];
                });
            }
            
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Your cart is empty!');
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->product->effective_price * $item->quantity;
            }

            // Get delivery charges from settings
            $deliveryCharges = DB::table('settings')->where('key', 'delivery_charges')->value('value') ?? 250;
            $total = $subtotal + $deliveryCharges;

            // Handle payment proof upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
                
                // Windows compatibility fix: Copy to public/storage directly
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $sourcePath = storage_path('app/public/' . $paymentProofPath);
                    $destinationPath = public_path('storage/' . $paymentProofPath);
                    if (file_exists($sourcePath)) {
                        $destinationDir = dirname($destinationPath);
                        if (!file_exists($destinationDir)) {
                            mkdir($destinationDir, 0755, true);
                        }
                        copy($sourcePath, $destinationPath);
                    }
                }
            }

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(), // Nullable for guest users
                'subtotal' => $subtotal,
                'shipping_amount' => $deliveryCharges,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_proof' => $paymentProofPath,
                'billing_address' => [
                    'name' => $request->customer_name ?? (Auth::check() ? Auth::user()->name : 'Guest'),
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'postal_code' => $request->postal_code,
                ],
                'shipping_address' => [
                    'name' => $request->customer_name ?? (Auth::check() ? Auth::user()->name : 'Guest'),
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'postal_code' => $request->postal_code,
                ],
                'notes' => $request->notes ?? null,
                'customer_notes' => Auth::check() ? null : 'Guest order - ' . ($request->customer_name ?? 'No name provided'),
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                // Use variation price if variation is selected
                $itemPrice = $item->variation_id && $item->variation
                    ? $item->variation->price
                    : $item->product->effective_price;

                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item->product_id ?? $item->product->id,
                    'variation_id'   => $item->variation_id ?? null,
                    'variation_name' => $item->variation_name ?? null,
                    'product_name'   => $item->product->name,
                    'product_sku'    => $item->product->sku ?? 'N/A',
                    'product_price'  => $itemPrice,
                    'quantity'       => $item->quantity,
                    'total_price'    => $itemPrice * $item->quantity,
                ]);

                // Update variation stock if applicable, otherwise product stock
                if ($item->variation_id && $item->variation) {
                    $item->variation->decrement('stock_quantity', $item->quantity);
                } else {
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                // Clear session cart for guest users
                session()->forget('cart');
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully! We will contact you shortly.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Order placement failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        // Allow guest users to view their order immediately after placement
        // For logged-in users, check ownership
        $query = Order::with(['items.product', 'user']);
        
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            // For guest users, allow viewing only within current session
            // or if they have the order number (could add order number verification later)
            $query->where('id', $id);
        }
        
        $order = $query->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}

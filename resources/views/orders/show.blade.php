@extends('layouts.frontend')

@section('title', 'Order Confirmation - AJ Electric')

@section('content')
@php
    $whatsappNumber = preg_replace('/\D+/', '', $siteSettings->site_whatsapp ?? '');
    $customerName = $order->shipping_address['name'] ?? 'Customer';
    $customerPhone = $order->shipping_address['phone'] ?? 'N/A';
    $whatsappMessage = rawurlencode(
        "Order placed successfully.\n" .
        "Order #: {$order->order_number}\n" .
        "Name: {$customerName}\n" .
        "Phone: {$customerPhone}\n" .
        "Total: Rs. " . number_format($order->total_amount)
    );
    $whatsappUrl = $whatsappNumber ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}" : null;
@endphp
<div class="py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%); min-height: calc(100vh - 200px);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Message -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl p-6 sm:p-8 mb-6 text-center shadow-xl">
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-4">Your order has been received and is being processed.</p>
            <p class="text-sm text-gray-600">Order Number: <span class="font-mono font-bold text-green-700">{{ $order->order_number }}</span></p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-6 border-2 border-orange-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Order Summary
            </h2>

            <!-- Products -->
            <div class="space-y-3 mb-6">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × Rs. {{ number_format($item->product_price) }}</p>
                    </div>
                    <p class="font-bold text-gray-900">Rs. {{ number_format($item->total_price) }}</p>
                </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="space-y-2 mb-6">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal:</span>
                    <span class="font-medium">Rs. {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Delivery Charges:</span>
                    <span class="font-medium">Rs. {{ number_format($order->shipping_amount) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-300">
                    <span>Total:</span>
                    <span>Rs. {{ number_format($order->total_amount) }}</span>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-2">Delivery Information</h3>
                <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ $order->shipping_address['phone'] ?? 'N/A' }}</p>
                <p class="text-sm text-gray-600"><strong>Address:</strong> {{ $order->shipping_address['address'] ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 rounded-xl p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                What's Next?
            </h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="text-green-600 mr-2">✓</span>
                    <span>We will verify your payment within 24 hours</span>
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 mr-2">✓</span>
                    <span>You will receive a confirmation call from our team</span>
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 mr-2">✓</span>
                    <span>Your order will be dispatched within 1-2 business days</span>
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 mr-2">✓</span>
                    <span>Expected delivery: 3-5 business days</span>
                </li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('shop') }}" class="flex-1 btn-primary text-center py-3 px-6 rounded-lg font-semibold">
                Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="flex-1 text-center py-3 px-6 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                View Orders
            </a>
        </div>

        @if($whatsappUrl)
            <div class="mt-6 text-center text-sm text-gray-600">
                <p>We are sending your order details on WhatsApp.</p>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="text-green-600 font-semibold hover:underline">
                    If WhatsApp doesn't open, click here
                </a>
            </div>
        @endif
    </div>
</div>

@if($whatsappUrl)
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.open(@json($whatsappUrl), '_blank', 'noopener');
            }, 800);
        });
    </script>
@endif
@endsection


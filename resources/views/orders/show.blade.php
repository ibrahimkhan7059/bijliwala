@extends('layouts.frontend')

@section('title', 'Order Confirmation - Thank You!')

@push('styles')
<style>
.confetti {
    position: fixed;
    top: -10px;
    z-index: 1000;
    pointer-events: none;
}

.confetti-piece {
    width: 8px;
    height: 8px;
    background: #f43f5e;
    position: absolute;
    animation: confetti-fall 3s linear infinite;
}

.confetti-piece:nth-child(1) { background: #ef4444; left: 10%; animation-delay: 0s; }
.confetti-piece:nth-child(2) { background: #f97316; left: 20%; animation-delay: 0.5s; }
.confetti-piece:nth-child(3) { background: #eab308; left: 30%; animation-delay: 1s; }
.confetti-piece:nth-child(4) { background: #22c55e; left: 40%; animation-delay: 1.5s; }
.confetti-piece:nth-child(5) { background: #06b6d4; left: 50%; animation-delay: 2s; }
.confetti-piece:nth-child(6) { background: #3b82f6; left: 60%; animation-delay: 0.3s; }
.confetti-piece:nth-child(7) { background: #8b5cf6; left: 70%; animation-delay: 0.8s; }
.confetti-piece:nth-child(8) { background: #ec4899; left: 80%; animation-delay: 1.3s; }
.confetti-piece:nth-child(9) { background: #f43f5e; left: 90%; animation-delay: 1.8s; }

@keyframes confetti-fall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.slide-in {
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.bounce-in {
    animation: bounceIn 0.8s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
        opacity: 1;
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
    }
}
</style>
@endpush

@section('content')
@php
    $whatsappNumber = preg_replace('/\D+/', '', $siteSettings->site_whatsapp ?? '');
    $customerName = $order->shipping_address['name'] ?? 'Customer';
    $customerPhone = $order->shipping_address['phone'] ?? 'N/A';
    $whatsappMessage = rawurlencode(
        "🎉 Order placed successfully!\n\n" .
        "📋 Order #: {$order->order_number}\n" .
        "👤 Name: {$customerName}\n" .
        "📱 Phone: {$customerPhone}\n" .
        "💰 Total: Rs. " . number_format($order->total_amount) . "\n\n" .
        "Thank you for choosing Bijliwala! 🔌⚡"
    );
    $whatsappUrl = $whatsappNumber ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}" : null;
@endphp

<!-- Confetti Animation -->
<div class="confetti">
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
</div>
<<div class="py-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: calc(100vh - 200px); position: relative; overflow: hidden;">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Main Success Card -->
        <div class="bounce-in bg-gradient-to-br from-white via-green-50 to-emerald-50 border-4 border-green-400 rounded-3xl p-8 sm:p-12 mb-8 text-center shadow-2xl relative overflow-hidden">
            
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-200 to-emerald-300 rounded-full -translate-y-16 translate-x-16 opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-br from-amber-200 to-orange-300 rounded-full translate-y-12 -translate-x-12 opacity-20"></div>
            
            <!-- Success Icon -->
            <div class="relative">
                <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 pulse-animation shadow-xl">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <!-- Celebration Emojis -->
                <div class="absolute -top-4 -left-4 text-3xl bounce-in" style="animation-delay: 0.2s;">🎉</div>
                <div class="absolute -top-2 -right-6 text-2xl bounce-in" style="animation-delay: 0.4s;">✨</div>
                <div class="absolute -bottom-2 -left-2 text-2xl bounce-in" style="animation-delay: 0.6s;">🎊</div>
                <div class="absolute -bottom-4 -right-4 text-3xl bounce-in" style="animation-delay: 0.8s;">🥳</div>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-extrabold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">
                Order Placed Successfully!
            </h1>
            <p class="text-lg sm:text-xl text-gray-700 mb-6 max-w-2xl mx-auto leading-relaxed">
                🎉 Congratulations {{ $customerName }}! Your order has been received and is being processed with care.
            </p>
            
            <!-- Order Number Display -->
            <div class="bg-gradient-to-r from-amber-100 to-orange-100 border-2 border-amber-300 rounded-2xl p-4 mb-6 inline-block">
                <p class="text-sm text-gray-600 mb-1">Your Order Number</p>
                <p class="text-2xl font-mono font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                    {{ $order->order_number }}
                </p>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                <div class="bg-white rounded-xl p-4 shadow-lg border border-gray-200">
                    <div class="text-2xl mb-2">📦</div>
                    <p class="text-sm text-gray-600">Items Ordered</p>
                    <p class="text-xl font-bold text-gray-900">{{ $order->items->sum('quantity') }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-lg border border-gray-200">
                    <div class="text-2xl mb-2">💰</div>
                    <p class="text-sm text-gray-600">Total Amount</p>
                    <p class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                        Rs. {{ number_format($order->total_amount) }}
                    </p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-lg border border-gray-200">
                    <div class="text-2xl mb-2">🚚</div>
                    <p class="text-sm text-gray-600">Expected Delivery</p>
                    <p class="text-xl font-bold text-gray-900">3-5 Days</p>
                </div>
            </div>
        </div>

        <!-- Order Details Card -->
        <div class="slide-in bg-white rounded-3xl shadow-2xl p-6 sm:p-8 mb-8 border border-gray-200" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    Order Summary
                </h2>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Order Date</p>
                    <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <!-- Products List -->
            <div class="space-y-4 mb-8">
                @foreach($order->items as $index => $item)
                <div class="fade-in bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-2xl p-4 sm:p-6 hover:shadow-lg transition-all duration-300" 
                     style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-start gap-4">
                                <!-- Product Image Placeholder -->
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-200 to-amber-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->product_name }}</h3>
                                    @if($item->variation_name)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 mb-2">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            {{ $item->variation_name }}
                                        </span>
                                    @endif
                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            SKU: {{ $item->product_sku }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            Qty: {{ $item->quantity }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                            </svg>
                                            Rs. {{ number_format($item->product_price) }} each
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                Rs. {{ number_format($item->total_price) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Totals -->
            <div class="bg-gradient-to-br from-gray-50 to-blue-50 border-2 border-blue-200 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Bill Breakdown
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Subtotal:
                        </span>
                        <span class="font-semibold text-gray-900">Rs. {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0M15 17a2 2 0 104 0" />
                            </svg>
                            Delivery Charges:
                        </span>
                        <span class="font-semibold text-gray-900">Rs. {{ number_format($order->shipping_amount) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl px-4 border-2 border-green-300">
                        <span class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            Total Amount:
                        </span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            Rs. {{ number_format($order->total_amount) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Customer Information -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-5">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Customer Details
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <strong>Name:</strong> 
                            <span class="ml-2">{{ $order->shipping_address['name'] ?? 'N/A' }}</span>
                        </p>
                        <p class="flex items-center text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <strong>Phone:</strong> 
                            <span class="ml-2">{{ $order->shipping_address['phone'] ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
                
                <!-- Delivery Information -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-5">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Delivery Address
                    </h4>
                    <div class="text-sm text-gray-700">
                        <p class="leading-relaxed">{{ $order->shipping_address['address'] ?? 'N/A' }}</p>
                        @if($order->shipping_address['postal_code'] ?? false)
                        <p class="mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <strong>Postal Code:</strong> 
                            <span class="ml-2">{{ $order->shipping_address['postal_code'] }}</span>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information Section -->
        @if($order->payment_method === 'advance' || $order->payment_method === 'bank_transfer')
        <div class="slide-in bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-300 rounded-3xl p-6 sm:p-8 mb-8 shadow-xl" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    Bank Transfer Payment Details
                </h2>
            </div>

            <!-- Bank Information -->
            @if($siteSettings->bank_name || $siteSettings->account_number)
            <div class="bg-white rounded-2xl p-6 border border-green-200 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">📋 Account Information</h3>
                <div class="space-y-3">
                    @if($siteSettings->bank_name)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Bank Name:</span>
                        <span class="text-gray-900 font-bold text-lg">{{ $siteSettings->bank_name }}</span>
                    </div>
                    @endif
                    
                    @if($siteSettings->account_number)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Account Number:</span>
                        <span class="text-gray-900 font-mono font-bold text-lg break-all">{{ $siteSettings->account_number }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between p-3 bg-green-100 border-2 border-green-300 rounded-lg">
                        <span class="text-gray-700 font-bold">Amount to Transfer:</span>
                        <span class="text-green-700 font-bold text-2xl">Rs. {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6">
                <h3 class="font-bold text-amber-900 mb-4 flex items-center text-lg">
                    <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payment Instructions
                </h3>
                <ol class="space-y-3 text-sm text-amber-900">
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-300 text-amber-900 font-bold text-xs mr-3 flex-shrink-0">1</span>
                        <span>Transfer the exact amount shown above to the bank account</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-300 text-amber-900 font-bold text-xs mr-3 flex-shrink-0">2</span>
                        <span>Take a screenshot or photo of the payment proof (transaction receipt)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-300 text-amber-900 font-bold text-xs mr-3 flex-shrink-0">3</span>
                        <span>Upload the payment proof in your order details page</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-300 text-amber-900 font-bold text-xs mr-3 flex-shrink-0">4</span>
                        <span>Our team will verify and process your order immediately</span>
                    </li>
                </ol>
            </div>

            <!-- Status Note -->
            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                <p class="text-sm text-yellow-800">
                    <strong>⏱️ Note:</strong> Your order will be processed once payment verification is complete. You'll receive a WhatsApp confirmation when your payment is verified.
                </p>
            </div>
        </div>
        @elseif($order->payment_method === 'cod')
        <div class="slide-in bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-300 rounded-3xl p-6 sm:p-8 mb-8 shadow-xl" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    Cash on Delivery (COD)
                </h2>
            </div>

            <!-- COD Information -->
            <div class="bg-white rounded-2xl p-6 border border-blue-200 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">💰 Payment Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Payment Method:</span>
                        <span class="text-gray-900 font-bold text-lg bg-blue-100 px-3 py-1 rounded-full">Pay at Delivery</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Delivery Charges:</span>
                        <span class="text-gray-900 font-bold text-lg">Rs. {{ number_format($order->shipping_amount) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-100 border-2 border-blue-300 rounded-lg">
                        <span class="text-gray-700 font-bold">Total Amount Due:</span>
                        <span class="text-blue-700 font-bold text-2xl">Rs. {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-cyan-50 border-2 border-cyan-300 rounded-2xl p-6">
                <h3 class="font-bold text-cyan-900 mb-4 flex items-center text-lg">
                    <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Delivery & Payment Process
                </h3>
                <ol class="space-y-3 text-sm text-cyan-900">
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-cyan-300 text-cyan-900 font-bold text-xs mr-3 flex-shrink-0">1</span>
                        <span>Our team will contact you on the provided number to confirm delivery</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-cyan-300 text-cyan-900 font-bold text-xs mr-3 flex-shrink-0">2</span>
                        <span>We'll deliver your items within 3-5 business days</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-cyan-300 text-cyan-900 font-bold text-xs mr-3 flex-shrink-0">3</span>
                        <span>Make payment (Rs. {{ number_format($order->total_amount) }}) to the delivery person</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-cyan-300 text-cyan-900 font-bold text-xs mr-3 flex-shrink-0">4</span>
                        <span>Receive your items and verify the products before completion</span>
                    </li>
                </ol>
            </div>

            <!-- Status Note -->
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                <p class="text-sm text-blue-800">
                    <strong>✓ Status:</strong> Your order is confirmed! You'll receive a confirmation call and WhatsApp message with delivery details shortly.
                </p>
            </div>
        </div>
        @endif

        <!-- What's Next Section -->
        <div class="slide-in bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200 rounded-3xl p-6 sm:p-8 mb-8 shadow-xl" style="animation-delay: 0.6s;">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                What Happens Next?
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Timeline Steps -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 fade-in" style="animation-delay: 1.1s;">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Payment Verification</h4>
                            <p class="text-sm text-gray-600">We verify your payment within 24 hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4 fade-in" style="animation-delay: 1.2s;">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Order Confirmation</h4>
                            <p class="text-sm text-gray-600">You'll receive a confirmation call from our team</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4 fade-in" style="animation-delay: 1.3s;">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">3</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Order Processing</h4>
                            <p class="text-sm text-gray-600">Your order will be prepared within 1-2 business days</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4 fade-in" style="animation-delay: 1.4s;">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">4</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Fast Delivery</h4>
                            <p class="text-sm text-gray-600">Expected delivery: 3-5 business days</p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="bg-white rounded-2xl p-6 border border-purple-200">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Important Notes
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 flex-shrink-0 mt-0.5">✓</span>
                            <span>Keep your order number safe for future reference</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 flex-shrink-0 mt-0.5">✓</span>
                            <span>Our team will contact you at {{ $order->shipping_address['phone'] ?? 'your registered phone' }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 flex-shrink-0 mt-0.5">✓</span>
                            <span>WhatsApp updates will be sent for order status</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 flex-shrink-0 mt-0.5">✓</span>
                            <span>Contact us immediately if you need to make any changes</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="slide-in grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8" style="animation-delay: 1.5s;">
            <a href="{{ route('shop') }}" 
               class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-4 px-6 rounded-2xl font-bold text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Continue Shopping
            </a>
            
            @auth
            <a href="{{ route('orders.index') }}" 
               class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white py-4 px-6 rounded-2xl font-bold text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                My Orders
            </a>
            @endauth
            
            @if($whatsappUrl)
            <a href="{{ $whatsappUrl }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-4 px-6 rounded-2xl font-bold text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.786"/>
                </svg>
                Chat on WhatsApp
            </a>
            @endif
        </div>
        
        <!-- Thank You Message -->
        <div class="slide-in text-center bg-gradient-to-r from-orange-100 to-amber-100 border-2 border-orange-300 rounded-3xl p-8" style="animation-delay: 1.6s;">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">
                Thank You for Choosing Bijliwala! ⚡
            </h3>
            <p class="text-lg text-gray-700 mb-4">
                We're excited to serve you with quality electrical and solar products. 
                Your trust in us means everything! 🌟
            </p>
            <p class="text-sm text-gray-600">
                Have questions? Our customer support team is ready to help you 24/7 via WhatsApp.
            </p>
            
            <!-- Social Media Icons (Optional) -->
            <div class="flex justify-center space-x-4 mt-6">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">⚡</span>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-400 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">🔌</span>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">💡</span>
                </div>
            </div>
        </div>
    </div>
</div>

@if($whatsappUrl)
    <script>
        // Auto-open WhatsApp after page loads
        window.addEventListener('load', function () {
            // Show a nice loading message
            const loadingMsg = document.createElement('div');
            loadingMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 fade-in';
            loadingMsg.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Opening WhatsApp...</span>
                </div>
            `;
            document.body.appendChild(loadingMsg);
            
            // Open WhatsApp after a short delay
            setTimeout(function () {
                window.open(@json($whatsappUrl), '_blank', 'noopener');
                
                // Remove loading message
                setTimeout(() => {
                    loadingMsg.remove();
                }, 2000);
            }, 1500);
        });

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click sound effect (optional)
            const buttons = document.querySelectorAll('a[class*="btn"], button');
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Confetti cleanup after animation
            setTimeout(() => {
                const confetti = document.querySelector('.confetti');
                if (confetti) {
                    confetti.style.opacity = '0';
                    setTimeout(() => confetti.remove(), 1000);
                }
            }, 8000);
        });
    </script>
@endif

@endsection
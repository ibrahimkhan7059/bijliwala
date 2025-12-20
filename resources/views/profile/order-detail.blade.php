@extends('layouts.frontend')

@section('title', 'Order Details #' . $order->id)

@push('styles')
<style>
    .order-detail-gradient {
        background: linear-gradient(135deg, #fff5e6 0%, #ffe4c4 25%, #ffd7a8 50%, #ffedd5 75%, #fff5e6 100%);
        background-attachment: fixed;
    }
</style>
@endpush

@section('content')
<div class="order-detail-gradient min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Order Details</h1>
                    <p class="text-sm md:text-base text-gray-600 mt-1">Order #{{ $order->id }} • {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
                <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
                    <a href="{{ route('orders.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors border border-amber-200 w-full sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Back to Orders</span>
                        <span class="sm:hidden">Back</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-4 md:space-y-6">
                <!-- Order Items -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6 flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Order Items ({{ $order->orderItems->count() }})
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ Storage::url($item->product->images->first()->image_path) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="h-20 w-20 md:h-24 md:w-24 object-cover rounded-lg border-2 border-amber-200">
                                @else
                                    <div class="h-20 w-20 md:h-24 md:w-24 bg-gradient-to-br from-amber-200 to-orange-200 rounded-lg flex items-center justify-center border-2 border-amber-200">
                                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1">
                                    <a href="{{ route('product.show', $item->product->slug ?? '#') }}" class="hover:text-amber-600 transition-colors">
                                        {{ $item->product->name ?? 'Product' }}
                                    </a>
                                </h3>
                                @if($item->product && $item->product->category)
                                <p class="text-sm text-amber-600 mb-2">{{ $item->product->category->name }}</p>
                                @endif
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                    <span>Quantity: <strong class="text-gray-900">{{ $item->quantity }}</strong></span>
                                    <span>Price: <strong class="text-gray-900">PKR {{ number_format($item->price, 2) }}</strong></span>
                                </div>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="text-right">
                                <div class="text-lg md:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                    PKR {{ number_format($item->quantity * $item->price, 2) }}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Subtotal</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4 md:space-y-6">
                <!-- Order Summary -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6 flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Order Summary
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm md:text-base">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">PKR {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm md:text-base">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold text-gray-900">Free</span>
                        </div>
                        <div class="border-t-2 border-amber-200 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="text-base md:text-lg font-bold text-gray-900">Total</span>
                                <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                    PKR {{ number_format($order->total_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6 flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Order Status
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 border border-{{ $order->status_color }}-300">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Payment Status</label>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-{{ $order->payment_status_color }}-100 text-{{ $order->payment_status_color }}-800 border border-{{ $order->payment_status_color }}-300">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($order->payment_method)
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Payment Method</label>
                            <p class="mt-2 text-sm font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6 flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Shipping Address
                    </h2>
                    
                    <div class="text-sm text-gray-700 space-y-1">
                        @if(is_array($order->shipping_address))
                            <p class="font-semibold">{{ $order->shipping_address['name'] ?? '' }}</p>
                            <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                            <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }}</p>
                            <p>{{ $order->shipping_address['postal_code'] ?? '' }}</p>
                            @if(isset($order->shipping_address['phone']))
                            <p class="mt-2 text-amber-600 font-medium">{{ $order->shipping_address['phone'] }}</p>
                            @endif
                        @else
                            <p>{{ $order->shipping_address }}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection



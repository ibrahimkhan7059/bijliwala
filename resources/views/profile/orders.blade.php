@extends('layouts.frontend')

@section('title', 'Order History')

@push('styles')
<style>
    .order-gradient {
        background: linear-gradient(135deg, #fff5e6 0%, #ffe4c4 25%, #ffd7a8 50%, #ffedd5 75%, #fff5e6 100%);
        background-attachment: fixed;
    }
</style>
@endpush

@section('content')
<div class="order-gradient min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Order History</h1>
                    <p class="text-sm md:text-base text-gray-600 mt-1">View all your past orders and their status</p>
                </div>
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors border border-amber-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Profile
                </a>
            </div>
        </div>

        @if($orders->count() > 0)
            <!-- Orders List -->
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border-2 border-amber-200/50 overflow-hidden hover:shadow-xl transition-all">
                    <a href="{{ route('orders.show', $order->id) }}" class="block">
                        <div class="p-4 md:p-6">
                            <!-- Order Header -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg md:text-xl font-bold text-gray-900">Order #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                                
                                <div class="text-left sm:text-right w-full sm:w-auto">
                                    <div class="text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-2">
                                        PKR {{ number_format($order->total_amount, 2) }}
                                    </div>
                                    <div class="flex flex-wrap gap-2 justify-start sm:justify-end">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 border border-{{ $order->status_color }}-300">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $order->payment_status_color }}-100 text-{{ $order->payment_status_color }}-800 border border-{{ $order->payment_status_color }}-300">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            <div class="border-t border-amber-200 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Items ({{ $order->orderItems->count() }})</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($order->orderItems->take(3) as $item)
                                    <div class="flex items-center space-x-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-3 border border-amber-200">
                                        @if($item->product && is_array($item->product->images) && count($item->product->images) > 0)
                                            <img src="{{ asset('storage/' . $item->product->images[0]) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="h-12 w-12 object-cover rounded-lg">
                                        @else
                                            <div class="h-12 w-12 bg-gradient-to-r from-amber-200 to-orange-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name ?? $item->product_name ?? 'Product' }}</p>
                                            <p class="text-xs text-gray-600">Qty: {{ $item->quantity }} × PKR {{ number_format($item->product_price, 2) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($order->orderItems->count() > 3)
                                    <div class="flex items-center justify-center bg-gradient-to-r from-amber-100 to-orange-100 rounded-lg p-3 border border-amber-300">
                                        <span class="text-sm font-semibold text-amber-700">+{{ $order->orderItems->count() - 3 }} more items</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- View Details Link -->
                            <div class="mt-4 pt-4 border-t border-amber-200">
                                <div class="flex items-center justify-end text-amber-600 hover:text-amber-700 font-semibold text-sm">
                                    View Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-8 md:p-12 text-center">
                <div class="p-4 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                   style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;">
                    Start Shopping
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection



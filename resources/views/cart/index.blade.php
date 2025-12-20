@extends('layouts.frontend')

@section('title', 'Shopping Cart')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%); min-height: calc(100vh - 200px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-xl sm:text-2xl md:text-4xl font-extrabold text-gray-900 mb-4 sm:mb-6 md:mb-8 flex items-center">
            <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="truncate">Shopping Cart</span>
        </h1>

        @if((Auth::check() && $cartItems->count() > 0) || (!Auth::check() && count($cartItems) > 0))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-8">
            
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @if(Auth::check())
                    @foreach($cartItems as $item)
                    <div class="bg-gradient-to-r from-orange-50 via-amber-50 to-yellow-50 rounded-xl shadow-lg p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:gap-6 border-2 border-orange-200">
                        <!-- Product Image -->
                        <div class="w-full sm:w-24 h-48 sm:h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden relative group"
                             x-data="{
                                currentImage: 0,
                                totalImages: {{ $item->product->images ? count($item->product->images) : 0 }},
                                autoPlay: false,
                                autoPlayInterval: null,
                                isHovering: false,
                                nextImage() {
                                    if (this.totalImages > 1) {
                                        this.currentImage = (this.currentImage + 1) % this.totalImages;
                                    }
                                },
                                prevImage() {
                                    if (this.totalImages > 1) {
                                        this.currentImage = this.currentImage === 0 ? this.totalImages - 1 : this.currentImage - 1;
                                    }
                                },
                                startAutoPlay() {
                                    if (this.totalImages > 1) {
                                        this.autoPlayInterval = setInterval(() => {
                                            if (this.autoPlay) {
                                                this.nextImage();
                                            }
                                        }, 1500);
                                    }
                                },
                                clearAutoPlay() {
                                    if (this.autoPlayInterval) {
                                        clearInterval(this.autoPlayInterval);
                                        this.autoPlayInterval = null;
                                    }
                                }
                             }"
                             @mouseenter="if(totalImages > 1) { isHovering = true; autoPlay = true; startAutoPlay(); }"
                             @mouseleave="isHovering = false; autoPlay = false; clearAutoPlay();">
                            @if($item->product->images && count($item->product->images) > 0)
                                @foreach($item->product->images as $index => $image)
                                <img x-show="currentImage === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $item->product->name }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                                @endforeach
                                
                                @if(count($item->product->images) > 1)
                                <!-- Navigation Arrows -->
                                <button @click="prevImage()" 
                                        x-show="isHovering"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        class="absolute left-1 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1 transition-all z-10"
                                        @mouseenter.stop="autoPlay = false; clearAutoPlay();"
                                        @mouseleave.stop="autoPlay = true; startAutoPlay();">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="nextImage()" 
                                        x-show="isHovering"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1 transition-all z-10"
                                        @mouseenter.stop="autoPlay = false; clearAutoPlay();"
                                        @mouseleave.stop="autoPlay = true; startAutoPlay();">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                
                                <!-- Image Counter -->
                                <div x-show="isHovering"
                                     x-transition:enter="transition ease-out duration-200"
                                     class="absolute bottom-1 right-1 bg-black/60 text-white px-1.5 py-0.5 rounded text-xs z-10">
                                    <span x-text="currentImage + 1"></span>/{{ count($item->product->images) }}
                                </div>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">
                                        <a href="{{ route('product.show', $item->product->slug) }}" class="hover:text-indigo-600">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-600">SKU: {{ $item->product->sku }}</p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @auth
                                    @php
                                        $inWishlist = Auth::user()->wishlistItems()->where('product_id', $item->product->id)->exists();
                                    @endphp
                                    <form action="{{ $inWishlist ? route('wishlist.destroy', Auth::user()->wishlistItems()->where('product_id', $item->product->id)->first()) : route('wishlist.store', $item->product) }}" method="POST">
                                        @csrf
                                        @if($inWishlist)
                                            @method('DELETE')
                                        @endif
                                        <button type="submit" class="text-gray-600 hover:text-red-600 p-1 transition-colors" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $inWishlist ? 'text-red-600 fill-current' : '' }}" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endauth
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Remove from Cart">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <!-- Quantity -->
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="text-xs sm:text-sm text-gray-600">Qty:</label>
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="{{ $item->product->stock_quantity }}"
                                           class="w-16 sm:w-20 px-2 py-1.5 border border-gray-300 rounded text-center text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500"
                                           onchange="this.form.submit()">
                                    <span class="text-xs text-gray-500 hidden sm:inline">(Max: {{ $item->product->stock_quantity }})</span>
                                </form>

                                <!-- Price -->
                                <div class="text-left sm:text-right">
                                    <p class="text-base sm:text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($item->product->effective_price * $item->quantity) }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        Rs. {{ number_format($item->product->effective_price) }} each
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach($cartItems as $productId => $item)
                    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:gap-6">
                        <!-- Product Image -->
                        <div class="w-full sm:w-24 h-48 sm:h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden relative group">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">{{ $item['name'] }}</h3>
                                </div>
                                <form action="{{ route('cart.remove', $productId) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <!-- Quantity -->
                                <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="text-xs sm:text-sm text-gray-600">Qty:</label>
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $item['quantity'] }}" 
                                           min="1"
                                           class="w-16 sm:w-20 px-2 py-1.5 border border-gray-300 rounded text-center text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500"
                                           onchange="this.form.submit()">
                                </form>

                                <!-- Price -->
                                <div class="text-left sm:text-right">
                                    <p class="text-base sm:text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($item['price'] * $item['quantity']) }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        Rs. {{ number_format($item['price']) }} each
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

                <!-- Clear Cart Button -->
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Clear Cart
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1 order-first lg:order-last">
                <div class="bg-gradient-to-br from-amber-50 via-orange-100 to-yellow-100 backdrop-blur-sm rounded-2xl shadow-xl p-4 sm:p-6 lg:sticky lg:top-20 border-2 border-orange-300">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Order Summary</h2>
                    
                    <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6">
                        <div class="flex justify-between text-sm sm:text-base text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">Rs. {{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base text-gray-600">
                            <span>Delivery</span>
                            <span class="font-medium text-green-600">FREE</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 sm:pt-3">
                            <div class="flex justify-between text-base sm:text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span>Rs. {{ number_format($total) }}</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <a href="#" class="block w-full btn-primary text-center py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg text-sm sm:text-base font-semibold mb-3">
                            Proceed to Checkout
                        </a>
                    @else
                        <div class="mb-4 p-3 sm:p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-xs sm:text-sm text-yellow-800">Please login to checkout</p>
                        </div>
                        <a href="{{ route('login') }}" class="block w-full btn-primary text-center py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg text-sm sm:text-base font-semibold mb-3">
                            Login to Checkout
                        </a>
                    @endauth

                    <a href="{{ route('shop') }}" class="block w-full text-center py-2.5 sm:py-3 px-4 sm:px-6 border border-gray-300 rounded-lg text-sm sm:text-base font-semibold text-gray-700 hover:bg-gray-50">
                        Continue Shopping
                    </a>

                    <!-- Features -->
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 space-y-2 sm:space-y-3">
                        <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-600">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Free delivery on all orders</span>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-600">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Cash on Delivery available</span>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Delivery in 3-5 business days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-gradient-to-br from-orange-50 via-amber-100 to-yellow-50 rounded-2xl shadow-xl p-6 sm:p-8 md:p-12 text-center border-2 border-orange-200">
            <svg class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Start adding products to your cart!</p>
            <a href="{{ route('shop') }}" class="btn-primary inline-block py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg text-sm sm:text-base font-semibold">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

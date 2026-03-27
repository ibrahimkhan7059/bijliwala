@extends('layouts.frontend')

@section('title', 'AJ Electric - Cart')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%); min-height: calc(100vh - 200px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-xl sm:text-2xl md:text-4xl font-extrabold text-gray-900 mb-4 sm:mb-6 md:mb-8 flex items-center">
            <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="truncate">Shopping Cart</span>
        </h1>

        <!-- Order Success Thank You Message -->
        @if(isset($orderSuccess) && $orderSuccess)
        <div class="mb-8 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 border-4 border-green-400 rounded-3xl p-6 md:p-8 text-center shadow-2xl relative overflow-hidden">
            
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-200 to-emerald-300 rounded-full -translate-y-16 translate-x-16 opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-br from-amber-200 to-orange-300 rounded-full translate-y-12 -translate-x-12 opacity-20"></div>
            
            <!-- Success Icon with Animation -->
            <div class="relative">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl animate-bounce">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <!-- Celebration Emojis -->
                <div class="absolute -top-2 -left-2 text-2xl">🎉</div>
                <div class="absolute -top-1 -right-3 text-xl">✨</div>
                <div class="absolute -bottom-1 -left-1 text-xl">🎊</div>
                <div class="absolute -bottom-2 -right-2 text-2xl">🥳</div>
            </div>
            
            <h2 class="text-2xl md:text-4xl font-extrabold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">
                Order Placed Successfully! 🎉
            </h2>
            <p class="text-lg md:text-xl text-gray-700 mb-6 max-w-2xl mx-auto">
                Thank you {{ $orderSuccess['customer_name'] }}! Your order has been received and is being processed.
            </p>
            
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-lg border-2 border-green-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Order Summary
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="text-lg font-bold text-green-700">{{ $orderSuccess['order_number'] }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Total Items</p>
                        <p class="text-lg font-bold text-gray-900">{{ $orderSuccess['items_count'] }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Total Amount</p>
                        <p class="text-lg font-bold text-green-700">Rs. {{ number_format($orderSuccess['total_amount']) }}</p>
                    </div>
                </div>
                
                <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                    <h4 class="font-semibold text-green-800 mb-2">What happens next?</h4>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>✓ We will verify your payment within 24 hours</li>
                        <li>✓ You will receive a confirmation call from our team</li>
                        <li>✓ Your order will be dispatched within 1-2 business days</li>
                        <li>✓ Expected delivery: 3-5 business days</li>
                    </ul>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('shop') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 px-6 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                    Continue Shopping
                </a>
                @if(isset($siteSettings) && $siteSettings->site_whatsapp)
                @php
                    $whatsappMessage = "🎉 Order placed successfully!\n\nOrder #: {$orderSuccess['order_number']}\nCustomer: {$orderSuccess['customer_name']}\nTotal: Rs. " . number_format($orderSuccess['total_amount']) . "\n\nThank you for choosing Bijliwala! ⚡🔌";
                @endphp
                <a href="https://wa.me/{{ $siteSettings->site_whatsapp }}?text={{ urlencode($whatsappMessage) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-6 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                    Chat on WhatsApp
                </a>
                @endif
            </div>
        </div>
        @endif

        @if((Auth::check() && $cartItems->count() > 0) || (!Auth::check() && count($cartItems) > 0))
        @if(!isset($orderSuccess) || !$orderSuccess)
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
                                    @if($item->variation_name)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                            {{ $item->variation_name }}
                                        </span>
                                    @endif
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">SKU: {{ $item->product->sku }}</p>
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
                                <div class="flex items-center gap-2">
                                    <label class="text-xs sm:text-sm text-gray-600">Qty:</label>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <!-- Decrease Button -->
                                        <button type="submit" name="decrease" value="1" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold transition-colors" @if($item->quantity <= 1) disabled @endif>
                                            −
                                        </button>
                                        
                                        <!-- Quantity Display -->
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="{{ $item->product->stock_quantity }}"
                                               class="w-12 px-2 py-1 border border-gray-300 rounded text-center text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500"
                                               readonly>
                                        
                                        <!-- Increase Button -->
                                        <button type="submit" name="increase" value="1" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold transition-colors" @if($item->quantity >= $item->product->stock_quantity) disabled @endif>
                                            +
                                        </button>
                                    </form>
                                    <span class="text-xs text-gray-500 hidden sm:inline">(Max: {{ $item->product->stock_quantity }})</span>
                                </div>

                                <!-- Price -->
                                <div class="text-left sm:text-right">
                                    <p class="text-base sm:text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($item->price * $item->quantity) }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        Rs. {{ number_format($item->price) }} each
                                        @if($item->variation_name)
                                            <br><span class="text-xs text-blue-600 font-medium">{{ $item->variation_name }}</span>
                                        @endif
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
                                <div class="flex items-center gap-2">
                                    <label class="text-xs sm:text-sm text-gray-600">Qty:</label>
                                    <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <!-- Decrease Button -->
                                        <button type="submit" name="decrease" value="1" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold transition-colors" @if($item['quantity'] <= 1) disabled @endif>
                                            −
                                        </button>
                                        
                                        <!-- Quantity Display -->
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1"
                                               class="w-12 px-2 py-1 border border-gray-300 rounded text-center text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500"
                                               readonly>
                                        
                                        <!-- Increase Button -->
                                        <button type="submit" name="increase" value="1" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold transition-colors">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Price -->
                                <div class="text-left sm:text-right">
                                    <p class="text-base sm:text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($item['price'] * $item['quantity']) }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        Rs. {{ number_format($item['price']) }} each
                                        @if(isset($item['variation_name']) && $item['variation_name'])
                                            <br><span class="text-xs text-blue-600 font-medium">{{ $item['variation_name'] }}</span>
                                        @endif
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
                <div class="bg-gradient-to-br from-amber-50 via-orange-100 to-yellow-100 backdrop-blur-sm rounded-2xl shadow-xl p-4 sm:p-6 lg:sticky lg:top-20 border-2 border-orange-300"
                     x-data="{
                        paymentMethod: 'bank_transfer',
                        subtotal: {{ $total }},
                        deliveryCharges: {{ $deliveryCharges }},
                        grandTotal: {{ $total }},
                        init() {
                            this.updateTotal();
                        },
                        updateTotal() {
                            if (this.paymentMethod === 'cod') {
                                this.grandTotal = this.subtotal + this.deliveryCharges;
                            } else if (this.paymentMethod === 'bank_transfer' || this.paymentMethod === 'advance') {
                                this.grandTotal = this.subtotal;
                            } else {
                                this.grandTotal = this.subtotal;
                            }
                        }
                     }">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Order Summary</h2>
                    
                    <!-- Payment Method Selection -->
                    <div class="mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-orange-200">
                        <label class="block text-sm font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Select Payment Method
                        </label>
                        <div class="space-y-2">
                            <!-- Bank Transfer Option -->
                            <label class="flex items-center p-3 border-2 border-green-200 rounded-lg cursor-pointer hover:bg-green-50 transition-colors"
                                   :class="paymentMethod === 'bank_transfer' ? 'bg-green-100 border-green-400' : 'bg-white'">
                                <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" @change="updateTotal()" class="w-4 h-4 text-green-600">
                                <span class="ml-2 flex-1">
                                    <span class="font-semibold text-gray-900">Bank Transfer (Advance)</span>
                                    <span class="block text-xs text-gray-600">Upload payment proof - NO delivery charges</span>
                                </span>
                            </label>
                            
                            <!-- COD Option -->
                            <label class="flex items-center p-3 border-2 border-blue-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors"
                                   :class="paymentMethod === 'cod' ? 'bg-blue-100 border-blue-400' : 'bg-white'">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" @change="updateTotal()" class="w-4 h-4 text-blue-600">
                                <span class="ml-2 flex-1">
                                    <span class="font-semibold text-gray-900">Cash on Delivery (COD)</span>
                                    <span class="block text-xs text-gray-600">Pay when item is delivered +{{ $deliveryCharges }} delivery</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6">
                        <div class="flex justify-between text-sm sm:text-base text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">Rs. <span x-text="subtotal.toLocaleString('en-PK')">{{ number_format($total) }}</span></span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base text-gray-600" x-show="paymentMethod === 'cod' || paymentMethod === 'bank_transfer'">
                            <span>Delivery Charges</span>
                            <span class="font-medium" x-show="paymentMethod === 'cod'">
                                Rs. <span x-text="deliveryCharges.toLocaleString('en-PK')">{{ number_format($deliveryCharges) }}</span>
                            </span>
                            <span class="font-medium text-green-600" x-show="paymentMethod === 'bank_transfer' || paymentMethod === 'advance'">FREE ✓</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 sm:pt-3">
                            <div class="flex justify-between text-base sm:text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span>Rs. <span x-text="grandTotal.toLocaleString('en-PK')">{{ number_format($grandTotal) }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Section (For Both Auth and Guest) -->
                    <div x-show="paymentMethod === 'bank_transfer' || paymentMethod === 'advance'" x-transition>
                        <!-- Bank Details for Payment -->
                        <div class="mb-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl">
                            <div class="flex items-center mb-3">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <h3 class="text-base font-bold text-gray-900">Payment Details</h3>
                            </div>
                            <div class="space-y-2 text-sm mb-3">
                                <div class="flex items-start">
                                    <span class="text-gray-600 font-medium w-24 flex-shrink-0">Bank:</span>
                                    <span class="text-gray-900 font-semibold">{{ $siteSettings->bank_name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="text-gray-600 font-medium w-24 flex-shrink-0">Account:</span>
                                    <span class="text-gray-900 font-mono text-xs sm:text-sm break-all">{{ $siteSettings->account_number ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="text-gray-600 font-medium w-24 flex-shrink-0">Amount:</span>
                                    <span class="text-green-700 font-bold text-lg">Rs. <span x-text="grandTotal.toLocaleString('en-PK')">{{ number_format($grandTotal) }}</span></span>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-green-200">
                                <p class="text-xs text-gray-700 leading-relaxed">
                                    <strong>📱 Steps:</strong> 1) Transfer amount to above account 2) Upload payment screenshot below 3) Submit order
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- COD Section (For Both Auth and Guest) -->
                    <div x-show="paymentMethod === 'cod'" x-transition class="mb-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-300 rounded-xl">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <h3 class="text-base font-bold text-gray-900">Cash on Delivery</h3>
                        </div>
                        <div class="space-y-2 text-sm mb-3">
                            <div class="flex items-start">
                                <span class="text-gray-600 font-medium w-24 flex-shrink-0">Payment:</span>
                                <span class="text-blue-700 font-semibold">Pay at delivery</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-gray-600 font-medium w-24 flex-shrink-0">Delivery:</span>
                                <span class="text-blue-700 font-semibold">{{ $deliveryCharges }} PKR</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-gray-600 font-medium w-24 flex-shrink-0">Total:</span>
                                <span class="text-blue-700 font-bold text-lg">Rs. <span x-text="grandTotal.toLocaleString('en-PK')">{{ number_format($grandTotal) }}</span></span>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-blue-200">
                            <p class="text-xs text-gray-700 leading-relaxed">
                                <strong>✓ Process:</strong> Order confirmed → Product delivery → Payment collection at doorstep
                            </p>
                        </div>
                    </div>

                    @auth
                        <!-- Registered User Order Form -->
                        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="payment_method" x-model="paymentMethod">
                            
                            @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="text-xs font-semibold text-red-800 mb-1">Please fix the following errors:</h3>
                                        <ul class="text-xs text-red-700 list-disc list-inside space-y-0.5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Phone Number -->
                            <div>
                                <label for="customer_phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="customer_phone" 
                                       id="customer_phone" 
                                       value="{{ old('customer_phone', Auth::user()->phone ?? '') }}"
                                       class="w-full px-3 py-2 text-sm border @error('customer_phone') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="03XX-XXXXXXX"
                                       required>
                                @error('customer_phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Delivery Address -->
                            <div>
                                <label for="customer_address" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Delivery Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="customer_address" 
                                          id="customer_address" 
                                          rows="2"
                                          class="w-full px-3 py-2 text-sm border @error('customer_address') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                          placeholder="Enter complete delivery address"
                                          required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label for="postal_code" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Postal Code
                                </label>
                                <input type="text"
                                       name="postal_code"
                                       id="postal_code"
                                       value="{{ old('postal_code') }}"
                                       class="w-full px-3 py-2 text-sm border @error('postal_code') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Enter postal code (optional)">
                                @error('postal_code')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Proof Upload (Only for Bank Transfer) -->
                            <div x-show="paymentMethod === 'bank_transfer' || paymentMethod === 'advance'" x-transition>
                                <label for="payment_proof" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Payment Screenshot <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="payment_proof" 
                                       id="payment_proof" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 text-sm border @error('payment_proof') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                       :required="paymentMethod === 'bank_transfer' || paymentMethod === 'advance'">
                                @error('payment_proof')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @else
                                    <p class="mt-1 text-xs text-gray-500">Upload payment screenshot (JPG, PNG, WEBP - Max 5MB)</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full btn-primary py-3 px-4 rounded-lg text-sm font-bold">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Submit Order
                            </button>
                        </form>
                    @else
                        <!-- Guest User Order Form -->
                        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            
                            @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="text-xs font-semibold text-red-800 mb-1">Please fix the following errors:</h3>
                                        <ul class="text-xs text-red-700 list-disc list-inside space-y-0.5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Customer Name -->
                            <div>
                                <label for="guest_name" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="customer_name" 
                                       id="guest_name" 
                                       value="{{ old('customer_name') }}"
                                       class="w-full px-3 py-2 text-sm border @error('customer_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Enter your full name"
                                       required>
                                @error('customer_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="guest_phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="customer_phone" 
                                       id="guest_phone" 
                                       value="{{ old('customer_phone') }}"
                                       class="w-full px-3 py-2 text-sm border @error('customer_phone') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="03XX-XXXXXXX"
                                       required>
                                @error('customer_phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Delivery Address -->
                            <div>
                                <label for="guest_address" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Delivery Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="customer_address" 
                                          id="guest_address" 
                                          rows="2"
                                          class="w-full px-3 py-2 text-sm border @error('customer_address') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                          placeholder="Enter complete delivery address"
                                          required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label for="guest_postal_code" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Postal Code
                                </label>
                                <input type="text"
                                       name="postal_code"
                                       id="guest_postal_code"
                                       value="{{ old('postal_code') }}"
                                       class="w-full px-3 py-2 text-sm border @error('postal_code') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Enter postal code (optional)">
                                @error('postal_code')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Proof Upload (Only for Advance Payment) -->
                            <div x-show="paymentMethod === 'advance'" x-transition>
                                <label for="guest_payment_proof" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Payment Screenshot <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="payment_proof" 
                                       id="guest_payment_proof" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 text-sm border @error('payment_proof') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                       :required="paymentMethod === 'advance'">
                                @error('payment_proof')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @else
                                    <p class="mt-1 text-xs text-gray-500">Upload payment screenshot (JPG, PNG, WEBP - Max 5MB)</p>
                                @enderror
                            </div>

                            <!-- Hidden payment method field -->
                            <input type="hidden" name="payment_method" x-model="paymentMethod">

                            <!-- Submit Button -->
                            <button type="submit" class="w-full btn-primary py-3 px-4 rounded-lg text-sm font-bold">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Submit Order
                            </button>
                        </form>

                        <!-- Or Login Link -->
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-600">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Login here</a>
                            </p>
                        </div>
                    @endauth

                    <!-- Features -->
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200 space-y-2 sm:space-y-3">
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
        @endif
        @endif
    </div>
</div>
@endsection

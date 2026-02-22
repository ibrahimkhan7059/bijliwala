@extends('layouts.frontend')

@section('title', $product->name)

@push('styles')
<style>
.scrollbar-hide {
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}
.scrollbar-hide::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}
</style>
@endpush

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%); min-height: calc(100vh - 200px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-4 md:mb-8 text-xs md:text-sm overflow-x-auto pb-2">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 whitespace-nowrap transition-colors">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('shop') }}" class="text-gray-500 hover:text-indigo-600 whitespace-nowrap transition-colors">Shop</a>
            @if($product->category)
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-gray-500 hover:text-indigo-600 whitespace-nowrap transition-colors">
                    {{ $product->category->name }}
                </a>
            @endif
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900 font-semibold truncate">{{ Str::limit($product->name, 30) }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-12 mb-8 md:mb-12">
            
            <!-- Product Images -->
            <div>
                @if($product->images && count($product->images) > 0)
                    <div x-data="{
                        activeImage: 0,
                        totalImages: {{ count($product->images) }},
                        lightboxOpen: false,
                        lightboxImage: 0,
                        touchStartX: 0,
                        touchEndX: 0,
                        nextImage() {
                            this.activeImage = (this.activeImage + 1) % this.totalImages;
                        },
                        prevImage() {
                            this.activeImage = this.activeImage === 0 ? this.totalImages - 1 : this.activeImage - 1;
                        },
                        openLightbox(index) {
                            this.lightboxImage = index;
                            this.lightboxOpen = true;
                            document.body.style.overflow = 'hidden';
                        },
                        closeLightbox() {
                            this.lightboxOpen = false;
                            document.body.style.overflow = '';
                        },
                        nextLightboxImage() {
                            this.lightboxImage = (this.lightboxImage + 1) % this.totalImages;
                        },
                        prevLightboxImage() {
                            this.lightboxImage = this.lightboxImage === 0 ? this.totalImages - 1 : this.lightboxImage - 1;
                        },
                        handleTouchStart(e) {
                            this.touchStartX = e.touches[0].clientX;
                        },
                        handleTouchEnd(e) {
                            this.touchEndX = e.changedTouches[0].clientX;
                            this.handleSwipe();
                        },
                        handleSwipe() {
                            const swipeThreshold = 50;
                            const swipeDistance = this.touchStartX - this.touchEndX;
                            
                            if (Math.abs(swipeDistance) > swipeThreshold) {
                                if (swipeDistance > 0) {
                                    this.nextImage(); // Swipe left - next image
                                } else {
                                    this.prevImage(); // Swipe right - previous image  
                                }
                            }
                        }
                    }" 
                    @keydown.arrow-right="lightboxOpen ? nextLightboxImage() : nextImage()" 
                    @keydown.arrow-left="lightboxOpen ? prevLightboxImage() : prevImage()"
                    @keydown.escape="closeLightbox()" 
                    @touchstart="handleTouchStart($event)"
                    @touchend="handleTouchEnd($event)"
                    tabindex="0"
                    class="sticky top-24 focus:outline-none select-none">
                        <!-- Main Image -->
                        <div class="relative aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden mb-3 md:mb-4 shadow-xl"
                             @mouseenter="if(totalImages > 1) { autoPlay = true; startAutoPlay(); }"
                             @mouseleave="autoPlay = false; clearAutoPlay();"
                             x-data="{
                                autoPlay: false,
                                autoPlayInterval: null,
                                startAutoPlay() {
                                    if (this.totalImages > 1) {
                                        this.autoPlayInterval = setInterval(() => {
                                            if (this.autoPlay) {
                                                this.nextImage();
                                            }
                                        }, 2000); // Change image every 2 seconds
                                    }
                                },
                                clearAutoPlay() {
                                    if (this.autoPlayInterval) {
                                        clearInterval(this.autoPlayInterval);
                                        this.autoPlayInterval = null;
                                    }
                                }
                             }">
                            <template x-for="(image, index) in {{ json_encode($product->images) }}" :key="index">
                                <img x-show="activeImage === index"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     :src="'{{ asset('storage') }}/' + image" 
                                     :alt="'{{ $product->name }}'"
                                     class="w-full h-full object-cover cursor-pointer transition-transform duration-300 hover:scale-110"
                                     @click="nextImage()"
                                     @dblclick="openLightbox(index)"
                                     loading="lazy">
                            </template>

                            <!-- Hover Instruction -->
                            @if(count($product->images) > 1)
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded-full text-sm opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                Hover for auto-scroll • Click or swipe to navigate
                            </div>
                            @endif

                            <!-- Navigation Arrows (only show if multiple images) -->
                            @if(count($product->images) > 1)
                            <button @click="prevImage()" 
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="nextImage()" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            
                            <!-- Image Counter -->
                            <div class="absolute top-4 left-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                                <span x-text="activeImage + 1"></span> / {{ count($product->images) }}
                            </div>
                            @endif
                            
                            <!-- Sale Badge -->
                            @if($product->on_sale)
                                <div class="absolute top-4 right-4 bg-gradient-to-r from-red-500 to-pink-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-xl">
                                    SAVE {{ $product->discount_percentage }}%
                                </div>
                            @endif
                        </div>

                        <!-- Thumbnails -->
                        @if(count($product->images) > 1)
                        <div class="relative">
                            <div class="flex overflow-x-auto gap-2 md:gap-3 scrollbar-hide pb-2" style="scroll-behavior: smooth;">
                                @foreach($product->images as $index => $image)
                                <button @click="activeImage = {{ $index }}"
                                        :class="activeImage === {{ $index }} ? 'ring-4 ring-indigo-600 scale-105' : 'ring-2 ring-gray-200'"
                                        class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 bg-gray-100 rounded-lg md:rounded-xl overflow-hidden hover:ring-4 hover:ring-indigo-400 transition-all duration-300">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                </button>
                                @endforeach
                            </div>
                            
                            <!-- Scroll indicators (optional) -->
                            @if(count($product->images) > 5)
                            <div class="absolute right-0 top-0 bottom-2 bg-gradient-to-l from-white to-transparent w-8 pointer-events-none"></div>
                            @endif
                        </div>

                        <!-- Touch/Swipe Instructions -->
                        <div class="text-center mt-3">
                            <p class="text-xs text-gray-500">
                                <span class="hidden md:inline">Use arrow keys or</span>
                                Tap thumbnails to view images
                            </p>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center shadow-xl">
                        <svg class="w-24 h-24 md:w-32 md:h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 backdrop-blur-md rounded-2xl shadow-2xl p-4 md:p-8 border-2 border-orange-200">
                <!-- Category Badge -->
                @if($product->category)
                <div class="inline-flex items-center bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700 px-3 py-1 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-semibold mb-3 md:mb-4">
                    <svg class="w-3 h-3 md:w-4 md:h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $product->category->name }}
                </div>
                @endif

                <!-- Product Name -->
                <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-3 md:mb-4 leading-tight">{{ $product->name }}</h1>

                <!-- SKU -->
                <p class="text-xs md:text-sm text-gray-600 mb-4 md:mb-6 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                    SKU: <span class="font-semibold ml-1">{{ $product->sku }}</span>
                </p>

                <!-- Price -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                    <div class="flex flex-wrap items-end gap-3 md:gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-600 mb-1">Current Price</p>
                            <span class="text-3xl md:text-5xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                Rs. {{ number_format($product->effective_price) }}
                            </span>
                        </div>
                        @if($product->on_sale)
                            <div class="flex flex-col">
                                <span class="text-base md:text-2xl text-gray-500 line-through">
                                    Rs. {{ number_format($product->price) }}
                                </span>
                                <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-3 py-1 rounded-lg text-xs md:text-sm font-bold shadow-lg inline-block">
                                    Save {{ $product->discount_percentage }}%
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-4 md:mb-6">
                    @if($product->stock_quantity > 0)
                        <div class="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-3 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-sm md:text-base">In Stock - {{ $product->stock_quantity }} available</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 bg-red-50 text-red-700 px-4 py-3 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-sm md:text-base">Out of Stock</span>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($product->description)
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Product Description
                    </h3>
                    <div class="text-sm md:text-base text-gray-700 leading-relaxed prose prose-sm max-w-none">
                        {!! $product->description !!}
                    </div>
                </div>
                @endif

                <!-- Product Variations -->
                @if($product->hasVariations() && $product->activeVariations->count() > 0)
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.871 4A17.926 17.926 0 003 12c0 2.874.673 5.59 1.871 8m14.13 0a17.926 17.926 0 001.87-8c0-2.874-.673-5.59-1.87-8M9 9h1.246a1 1 0 01.961.725l1.586 5.55A1 1 0 0013.754 16H15m-3-7v6m-5-6v6m5-6H9.5a1 1 0 00-.96.725L7.754 12H6" />
                        </svg>
                        Product Options
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($product->activeVariations as $variation)
                        <div class="bg-white rounded-lg p-4 border-2 border-blue-200 hover:border-blue-400 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $variation->name }}</h4>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $variation->type ?? 'Option' }}
                                </span>
                            </div>
                            
                            @if($variation->description)
                            <p class="text-sm text-gray-600 mb-3">{!! $variation->description !!}</p>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                @if($variation->price && $variation->price != $product->price)
                                <div class="text-sm">
                                    <span class="font-semibold text-green-600">
                                        +Rs. {{ number_format($variation->price - $product->price) }}
                                    </span>
                                </div>
                                @endif
                                
                                @if($variation->stock_quantity !== null)
                                <div class="text-xs text-gray-500">
                                    Stock: {{ $variation->stock_quantity }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 md:space-y-6" 
                      x-data="{
                        selectedVariation: null,
                        basePrice: {{ $product->effective_price }},
                        currentPrice: {{ $product->effective_price }},
                        baseStock: {{ $product->stock_quantity }},
                        currentStock: {{ $product->stock_quantity }},
                        quantity: 1,
                        canAddToCart: true,
                        init() {
                            this.validateStock();
                        },
                        updateVariation() {
                            const select = this.$refs.variationSelect;
                            const option = select.options[select.selectedIndex];
                            
                            if (option.value) {
                                this.selectedVariation = option.value;
                                this.currentPrice = parseFloat(option.dataset.price) || this.basePrice;
                                this.currentStock = parseInt(option.dataset.stock) || this.baseStock;
                            } else {
                                this.selectedVariation = null;
                                this.currentPrice = this.basePrice;
                                this.currentStock = this.baseStock;
                            }
                            this.validateStock();
                        },
                        updateQuantity() {
                            // Ensure quantity is not negative or zero
                            if (this.quantity < 1) {
                                this.quantity = 1;
                            }
                            // Ensure quantity doesn't exceed stock
                            if (this.quantity > this.currentStock) {
                                this.quantity = this.currentStock;
                            }
                            this.validateStock();
                        },
                        increaseQuantity() {
                            if (this.quantity < this.currentStock) {
                                this.quantity++;
                                this.validateStock();
                            }
                        },
                        decreaseQuantity() {
                            if (this.quantity > 1) {
                                this.quantity--;
                                this.validateStock();
                            }
                        },
                        validateStock() {
                            // Button should be disabled if:
                            // 1. No stock available (currentStock <= 0)
                            // 2. Selected quantity is more than available stock
                            this.canAddToCart = (this.currentStock > 0) && (this.quantity <= this.currentStock) && (this.quantity > 0);
                            console.log('Stock validation:', {
                                currentStock: this.currentStock,
                                quantity: this.quantity,
                                canAddToCart: this.canAddToCart
                            });
                        }
                      }">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Dynamic Price Display -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                <span class="font-bold text-gray-900">Total Price:</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent" 
                                      x-text="'Rs. ' + (currentPrice * quantity).toLocaleString()">
                                    Rs. {{ number_format($product->effective_price) }}
                                </span>
                                <div class="text-sm text-gray-600" x-show="selectedVariation">
                                    <span x-text="'Rs. ' + currentPrice.toLocaleString() + ' × ' + quantity"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="mt-3 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" :class="currentStock > 0 ? 'bg-green-500' : 'bg-red-500'"></div>
                            <span class="text-sm font-semibold" :class="currentStock > 0 ? 'text-green-700' : 'text-red-700'">
                                <span x-text="currentStock + ' items available'"></span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Variation Selector -->
                    @if($product->hasVariations() && $product->activeVariations->count() > 0)
                    <div class="bg-white border-2 border-blue-200 rounded-xl p-4">
                        <label class="block text-sm md:text-base font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Select Variation
                        </label>
                        <select name="variation_id" 
                                x-ref="variationSelect"
                                @change="updateVariation()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base">
                            <option value="">Standard Product (Rs. {{ number_format($product->effective_price) }})</option>
                            @foreach($product->activeVariations as $variation)
                            <option value="{{ $variation->id }}" 
                                    data-price="{{ $variation->price }}" 
                                    data-stock="{{ $variation->stock_quantity ?? $product->stock_quantity }}">
                                {{ $variation->name }}
                                @if($variation->price && $variation->price != $product->price)
                                    (Rs. {{ number_format($variation->price) }})
                                @endif
                                @if($variation->stock_quantity !== null)
                                    - Stock: {{ $variation->stock_quantity }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <!-- Quantity Selector -->
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-4">
                        <label for="quantity" class="block text-sm md:text-base font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Select Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                                <button type="button" 
                                        @click="decreaseQuantity()"
                                        :disabled="quantity <= 1"
                                        :class="quantity <= 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-100 hover:bg-gray-200'"
                                        class="px-3 py-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       x-model.number="quantity"
                                       @input="updateQuantity()"
                                       min="1" 
                                       :max="currentStock"
                                       class="w-20 md:w-24 px-4 py-2 text-center border-0 focus:ring-0 text-lg font-bold">
                                <button type="button" 
                                        @click="increaseQuantity()"
                                        :disabled="quantity >= currentStock"
                                        :class="quantity >= currentStock ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-100 hover:bg-gray-200'"
                                        class="px-3 py-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                            <span class="text-xs md:text-sm text-gray-600 bg-gray-100 px-3 py-2 rounded-lg">
                                Max: <span class="font-bold" x-text="currentStock">{{ $product->stock_quantity }}</span>
                            </span>
                        </div>
                        
                        <!-- Stock Warning -->
                        <div x-show="!canAddToCart && currentStock > 0" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center gap-2 text-red-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-semibold">
                                    Quantity cannot exceed available stock! Only <span x-text="currentStock"></span> items available.
                                </span>
                            </div>
                        </div>
                        
                        <!-- Out of Stock Warning -->
                        <div x-show="currentStock <= 0" 
                             class="mt-3 p-3 bg-red-100 border border-red-300 rounded-lg">
                            <div class="flex items-center gap-2 text-red-800">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-semibold">
                                    This item is currently out of stock.
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" 
                            :disabled="!canAddToCart"
                            :class="canAddToCart ? 'btn-primary hover:shadow-3xl' : 'bg-gray-300 text-gray-600 cursor-not-allowed'"
                            class="w-full py-4 md:py-5 px-6 rounded-xl text-base md:text-xl font-bold flex items-center justify-center gap-3 shadow-2xl transition-all duration-300">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="canAddToCart">Add to Cart</span>
                        <span x-show="!canAddToCart">Cannot Add to Cart</span>
                    </button>
                </form>
                @else
                <button disabled class="w-full bg-gray-300 text-gray-600 py-4 md:py-5 px-6 rounded-xl text-base md:text-xl font-bold cursor-not-allowed">
                    Out of Stock
                </button>
                @endif

                <!-- Features -->
                <div class="mt-6 md:mt-8 pt-6 md:pt-8 border-t-2 border-gray-200">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Why Buy From Us
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <div class="flex items-center gap-3 bg-gradient-to-r from-green-50 to-emerald-50 p-3 md:p-4 rounded-xl">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-base text-gray-900">Genuine Product</p>
                                <p class="text-xs md:text-sm text-gray-600">100% Original</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 md:p-4 rounded-xl">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-base text-gray-900">Secure Payment</p>
                                <p class="text-xs md:text-sm text-gray-600">Multiple Options</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-gradient-to-r from-orange-50 to-yellow-50 p-3 md:p-4 rounded-xl">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-base text-gray-900">Fast Delivery</p>
                                <p class="text-xs md:text-sm text-gray-600">3-5 Business Days</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-gradient-to-r from-purple-50 to-pink-50 p-3 md:p-4 rounded-xl">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-base text-gray-900">24/7 Support</p>
                                <p class="text-xs md:text-sm text-gray-600">WhatsApp Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-8 md:mt-16 bg-gradient-to-br from-orange-50/50 via-amber-50/30 to-orange-50/50 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-8 border border-orange-200 shadow-xl">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <h2 class="text-xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 md:w-8 md:h-8 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Related Products
                </h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 rounded-xl shadow-lg overflow-hidden card-hover group border-2 border-orange-200">
                    <a href="{{ route('product.show', $relatedProduct->slug) }}" class="block aspect-square overflow-hidden bg-gray-100 relative">
                        @if($relatedProduct->images && count($relatedProduct->images) > 0)
                            <img src="{{ asset('storage/' . $relatedProduct->images[0]) }}" 
                                 alt="{{ $relatedProduct->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 md:w-24 h-16 md:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-3 md:p-4">
                        <a href="{{ route('product.show', $relatedProduct->slug) }}" class="text-sm md:text-base font-semibold text-gray-900 hover:text-indigo-600 line-clamp-2 mb-2 block transition-colors">
                            {{ $relatedProduct->name }}
                        </a>
                        <div class="flex items-center gap-1 md:gap-2 flex-wrap">
                            <span class="text-base md:text-lg font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                Rs. {{ number_format($relatedProduct->effective_price) }}
                            </span>
                            @if($relatedProduct->on_sale)
                                <span class="text-xs md:text-sm text-gray-500 line-through">Rs. {{ number_format($relatedProduct->price) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Lightbox Modal -->
    @if($product->images && count($product->images) > 0)
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
         @click.self="closeLightbox()">
        
        <div class="relative max-w-6xl max-h-full mx-4">
            <!-- Close Button -->
            <button @click="closeLightbox()" 
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Navigation Arrows -->
            @if(count($product->images) > 1)
            <button @click="prevLightboxImage()" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 transition-all z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <button @click="nextLightboxImage()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 transition-all z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Image Counter -->
            <div class="absolute -top-12 left-0 text-white text-sm">
                <span x-text="lightboxImage + 1"></span> / {{ count($product->images) }}
            </div>
            @endif

            <!-- Lightbox Image -->
            <div class="relative">
                @foreach($product->images as $index => $image)
                <img x-show="lightboxImage === {{ $index }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     src="{{ asset('storage/' . $image) }}" 
                     alt="{{ $product->name }}"
                     class="max-w-full max-h-[80vh] object-contain">
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.frontend')

@section('title', 'AJ Electric - ' . $product->name)

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
                    <p class="text-sm md:text-base text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 md:space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Quantity Selector -->
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-4">
                        <label for="quantity" class="block text-sm md:text-base font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Select Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-24 md:w-32 px-4 py-3 text-center border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-indigo-500 focus:border-indigo-500 text-lg font-bold">
                            <span class="text-xs md:text-sm text-gray-600 bg-gray-100 px-3 py-2 rounded-lg">
                                Max: <span class="font-bold">{{ $product->stock_quantity }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" class="w-full btn-primary py-4 md:py-5 px-6 rounded-xl text-base md:text-xl font-bold flex items-center justify-center gap-3 shadow-2xl hover:shadow-3xl">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Add to Cart</span>
                    </button>
                </form>
                @else
                <button disabled class="w-full bg-gray-300 text-gray-600 py-4 md:py-5 px-6 rounded-xl text-base md:text-xl font-bold cursor-not-allowed">
                    Out of Stock
                </button>
                @endif

                <!-- Divider with OR Text -->
                @if($siteSettings->site_whatsapp)
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-400 font-medium">OR</span>
                    </div>
                </div>

                <!-- WhatsApp Order Button -->
                @php
                    $whatsappMessage = "🛍️ *Product Inquiry*\n\n";
                    $whatsappMessage .= "📦 *Product:* " . $product->name . "\n";
                    if($product->sku) {
                        $whatsappMessage .= "🔖 *SKU:* " . $product->sku . "\n";
                    }
                    $whatsappMessage .= "💰 *Price:* " . $siteSettings->currency_symbol . number_format($product->effective_price, 2) . "\n";
                    if($product->discount_price) {
                        $whatsappMessage .= "💸 *Original Price:* " . $siteSettings->currency_symbol . number_format($product->price, 2) . "\n";
                        $whatsappMessage .= "🎉 *Discount:* " . $siteSettings->currency_symbol . number_format($product->price - $product->effective_price, 2) . " OFF\n";
                    }
                    $whatsappMessage .= "\nHi! I'm interested in this product. Please provide more details.";
                @endphp
                <a href="https://wa.me/{{ $siteSettings->site_whatsapp }}?text={{ urlencode($whatsappMessage) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="w-full bg-green-500 hover:bg-green-600 text-white py-4 md:py-5 px-6 rounded-xl text-base md:text-xl font-bold flex items-center justify-center gap-3 shadow-2xl hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span>Order on WhatsApp</span>
                </a>
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

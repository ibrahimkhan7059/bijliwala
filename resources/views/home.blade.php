@extends('layouts.frontend')

@section('title', 'AJ Electric - Home')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="relative rounded-2xl md:rounded-3xl shadow-2xl overflow-hidden mb-8 md:mb-12" style="background-image: url('{{ asset('images/sectionimg.jfif') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <!-- Overlay for better text readability -->
            <div class="absolute inset-0 bg-black/40"></div>
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 md:w-48 md:h-48 bg-yellow-300/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 md:w-48 md:h-48 bg-yellow-300/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 md:w-96 md:h-96 bg-yellow-400/10 rounded-full blur-3xl lightning-pulse"></div>
            
            <div class="relative px-4 py-8 md:p-12 lg:p-16 text-white text-center">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-3 md:mb-4 leading-tight text-white">
                        Welcome to <br class="md:hidden"/>{{ $siteSettings->site_name }}
                    </h1>
                    <p class="text-base md:text-xl lg:text-2xl mb-6 md:mb-8 text-indigo-100 leading-relaxed">
                        Your trusted source for quality electrical and solar products across Pakistan
                    </p>
                    
                    <!-- Features Grid -->
                    <div class="grid grid-cols-3 gap-3 md:gap-8 mb-6 md:mb-8 max-w-3xl mx-auto">
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 md:p-6 hover:bg-white/20 transition-all border border-white/20">
                            <div class="text-2xl md:text-4xl font-bold mb-1 md:mb-2">⚡ 3-5</div>
                            <div class="text-xs md:text-base text-yellow-100 font-semibold">Days Delivery</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 md:p-6 hover:bg-white/20 transition-all border border-white/20">
                            <div class="text-2xl md:text-4xl font-bold mb-1 md:mb-2">☀️ 24/7</div>
                            <div class="text-xs md:text-base text-yellow-100 font-semibold">Support</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 md:p-6 hover:bg-white/20 transition-all border border-white/20">
                            <div class="text-2xl md:text-4xl font-bold mb-1 md:mb-2">💯</div>
                            <div class="text-xs md:text-base text-yellow-100 font-semibold">Genuine</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('shop') }}" class="inline-flex items-center bg-white text-indigo-600 px-6 md:px-10 py-3 md:py-4 rounded-xl font-bold text-sm md:text-lg hover:scale-105 transition-transform shadow-2xl">
                        <span>Shop Now</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Section / Shop Section -->
        @if($categories->count() > 0)
        <div id="shop" class="mb-8 md:mb-12 bg-gradient-to-br from-orange-100/80 via-amber-50/90 to-yellow-100/80 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border-2 border-orange-200">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Shop by Category</h2>
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 md:gap-4">
                @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="bg-gradient-to-br from-amber-50 via-orange-100 to-yellow-50 p-4 md:p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all text-center group card-hover border-2 border-orange-200 hover:border-amber-400">
                    <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-2 md:mb-4 bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 rounded-2xl flex items-center justify-center text-white text-xl md:text-3xl group-hover:scale-110 transition-transform shadow-lg {{ $category->image ? 'overflow-hidden' : '' }}">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            ⚡
                        @endif
                    </div>
                    <h3 class="text-sm md:text-base font-semibold text-gray-900 group-hover:text-orange-600 transition-colors line-clamp-2">{{ $category->name }}</h3>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Featured Products / Products Section -->
        @if($featuredProducts->count() > 0)
        <div id="products" class="mb-8 md:mb-12 bg-gradient-to-br from-orange-100/90 via-amber-100/90 to-yellow-100/90 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border-2 border-orange-200">
            <div class="flex justify-between items-center mb-4 md:mb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">⭐</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Featured Products</h2>
                </div>
                <a href="{{ route('shop') }}" class="text-sm md:text-base text-indigo-600 hover:text-indigo-800 font-semibold flex items-center group">
                    <span>View All</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($featuredProducts as $product)
                <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 rounded-xl shadow-lg overflow-hidden card-hover group border-2 border-orange-200">
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="block aspect-square overflow-hidden bg-gray-100 relative"
                       x-data="{
                            currentImage: 0,
                            totalImages: {{ $product->images ? count($product->images) : 0 }},
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
                       @mouseleave="isHovering = false; autoPlay = false; clearAutoPlay(); currentImage = 0;">
                        @if($product->images && count($product->images) > 0)
                            @foreach($product->images as $index => $image)
                            <img x-show="currentImage === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 src="{{ asset('storage/' . $image) }}" 
                                 alt="{{ $product->name }}"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endforeach
                            
                            @if(count($product->images) > 1)
                            <!-- Navigation Arrows -->
                            <button @click.prevent="prevImage()" 
                                    x-show="isHovering"
                                    x-transition:enter="transition ease-out duration-200"
                                    class="absolute left-1 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1 transition-all z-10"
                                    @mouseenter.stop="autoPlay = false; clearAutoPlay();"
                                    @mouseleave.stop="autoPlay = true; startAutoPlay();">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click.prevent="nextImage()" 
                                    x-show="isHovering"
                                    x-transition:enter="transition ease-out duration-200"
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
                                <span x-text="currentImage + 1"></span>/{{ count($product->images) }}
                            </div>
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 md:w-24 h-16 md:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        @if($product->on_sale)
                            <span class="absolute top-2 right-2 bg-gradient-to-r from-red-500 to-pink-500 text-white px-2 py-1 rounded-full text-xs font-bold shadow-lg z-10">
                                SALE
                            </span>
                        @endif
                    </a>
                    <div class="p-3 md:p-4">
                        <a href="{{ route('product.show', $product->slug) }}" class="text-sm md:text-base font-semibold text-gray-900 hover:text-indigo-600 line-clamp-2 mb-2 block transition-colors">
                            {{ $product->name }}
                        </a>
                        <div class="flex items-center gap-1 md:gap-2 mb-3 flex-wrap">
                            <span class="text-lg md:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                Rs. {{ number_format($product->effective_price, 2) }}
                            </span>
                            @if($product->on_sale)
                                <span class="text-xs md:text-sm text-gray-500 line-through">Rs. {{ number_format($product->price, 2) }}</span>
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-semibold">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                        @if($product->stock_quantity > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-primary py-2 px-3 rounded-lg text-xs md:text-sm font-semibold flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        @else
                                <button disabled class="flex-1 bg-gray-300 text-gray-600 py-2 px-3 rounded-lg text-xs md:text-sm font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                            @auth
                            @php
                                $inWishlist = Auth::user()->wishlistItems()->where('product_id', $product->id)->exists();
                            @endphp
                            <form action="{{ $inWishlist ? route('wishlist.destroy', Auth::user()->wishlistItems()->where('product_id', $product->id)->first()) : route('wishlist.store', $product) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                @if($inWishlist)
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="p-2 border-2 border-gray-300 rounded-lg hover:border-red-500 hover:bg-red-50 transition-all {{ $inWishlist ? 'border-red-500 bg-red-50' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 {{ $inWishlist ? 'text-red-600 fill-current' : 'text-gray-600' }}" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sale Products -->
        @if($saleProducts->count() > 0)
        <div class="mb-8 md:mb-12 bg-gradient-to-br from-red-100/90 via-pink-100/90 to-orange-100/90 backdrop-blur-sm rounded-3xl p-6 md:p-8 shadow-xl border-2 border-red-200">
            <div class="flex justify-between items-center mb-4 md:mb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🔥</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-red-600">Sale Products</h2>
                </div>
                <a href="{{ route('shop') }}" class="text-sm md:text-base text-indigo-600 hover:text-indigo-800 font-semibold flex items-center group">
                    <span>View All</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($saleProducts as $product)
                <div class="bg-gradient-to-br from-red-50 via-pink-50 to-orange-50 rounded-xl shadow-lg overflow-hidden card-hover group relative border-2 border-red-200">
                    <div class="absolute top-2 right-2 z-10 bg-gradient-to-r from-red-500 to-pink-600 text-white px-2 md:px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                        -{{ $product->discount_percentage }}%
                    </div>
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="block aspect-square overflow-hidden bg-gray-100 relative"
                       x-data="{
                            currentImage: 0,
                            totalImages: {{ $product->images ? count($product->images) : 0 }},
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
                       @mouseleave="isHovering = false; autoPlay = false; clearAutoPlay(); currentImage = 0;">
                        @if($product->images && count($product->images) > 0)
                            @foreach($product->images as $index => $image)
                            <img x-show="currentImage === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 src="{{ asset('storage/' . $image) }}" 
                                 alt="{{ $product->name }}"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endforeach
                            
                            @if(count($product->images) > 1)
                            <!-- Navigation Arrows -->
                            <button @click.prevent="prevImage()" 
                                    x-show="isHovering"
                                    x-transition:enter="transition ease-out duration-200"
                                    class="absolute left-1 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1 transition-all z-10"
                                    @mouseenter.stop="autoPlay = false; clearAutoPlay();"
                                    @mouseleave.stop="autoPlay = true; startAutoPlay();">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click.prevent="nextImage()" 
                                    x-show="isHovering"
                                    x-transition:enter="transition ease-out duration-200"
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
                                <span x-text="currentImage + 1"></span>/{{ count($product->images) }}
                            </div>
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 md:w-24 h-16 md:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-3 md:p-4">
                        <a href="{{ route('product.show', $product->slug) }}" class="text-sm md:text-base font-semibold text-gray-900 hover:text-indigo-600 line-clamp-2 mb-2 block transition-colors">
                            {{ $product->name }}
                        </a>
                        <div class="flex items-center gap-1 md:gap-2 mb-3 flex-wrap">
                            <span class="text-lg md:text-xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Rs. {{ number_format($product->effective_price, 2) }}</span>
                            <span class="text-xs md:text-sm text-gray-500 line-through">Rs. {{ number_format($product->price, 2) }}</span>
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-semibold">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                        @if($product->stock_quantity > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-warning py-2 px-3 rounded-lg text-xs md:text-sm font-semibold flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-600 py-2 px-3 rounded-lg text-xs md:text-sm font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Contact Info / About Section -->
        <div id="about" class="bg-gradient-to-br from-gray-900 via-gray-800 to-orange-900 rounded-2xl md:rounded-3xl p-6 md:p-10 text-white shadow-2xl">
            <div class="text-center mb-6 md:mb-8">
                <h3 class="text-2xl md:text-3xl font-bold mb-2 text-white">About {{ $siteSettings->site_name }}</h3>
                <p class="text-gray-300 text-sm md:text-base">We're here to help you with all your electrical needs</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-6">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 md:p-6 hover:bg-white/20 transition-all text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-300 text-xs md:text-sm mb-1">Store Location</p>
                    <p class="font-bold text-sm md:text-base text-white">{!! nl2br(e($siteSettings->site_address)) !!}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 md:p-6 hover:bg-white/20 transition-all text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-300 text-xs md:text-sm mb-1">Delivery Time</p>
                    <p class="font-bold text-sm md:text-base text-white">3-5 Business Days</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-500/30 to-pink-500/30 backdrop-blur-md rounded-xl p-4 md:p-6 border border-red-400/50 text-center">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <p class="font-bold text-sm md:text-base text-white">Important Note</p>
                </div>
                <p class="text-xs md:text-sm text-gray-200 leading-relaxed">We don't work on cash on delivery. Please contact us via WhatsApp to place your order.</p>
            </div>

            <!-- Social Media Links -->
            @if(($siteSettings->social_facebook ?? null) || ($siteSettings->social_instagram ?? null) || ($siteSettings->social_tiktok ?? null) || ($siteSettings->social_youtube ?? null) || ($siteSettings->social_twitter ?? null))
            <div class="mt-6 md:mt-8 text-center">
                <h4 class="text-lg md:text-xl font-bold mb-4 text-white">Follow Us</h4>
                <div class="flex items-center justify-center space-x-4 md:space-x-6 flex-wrap gap-3 md:gap-4">
                    @if($siteSettings->social_facebook ?? null)
                    <a href="{{ $siteSettings->social_facebook }}" target="_blank" rel="noopener noreferrer" 
                       class="group bg-white/10 hover:bg-blue-600 backdrop-blur-md rounded-full p-3 md:p-4 transition-all duration-300 transform hover:scale-110 hover:shadow-xl border-2 border-white/20 hover:border-blue-400">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if($siteSettings->social_instagram ?? null)
                    <a href="{{ $siteSettings->social_instagram }}" target="_blank" rel="noopener noreferrer" 
                       class="group bg-white/10 hover:bg-gradient-to-r hover:from-purple-600 hover:via-pink-600 hover:to-orange-500 backdrop-blur-md rounded-full p-3 md:p-4 transition-all duration-300 transform hover:scale-110 hover:shadow-xl border-2 border-white/20 hover:border-pink-400">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if($siteSettings->social_tiktok ?? null)
                    <a href="{{ $siteSettings->social_tiktok }}" target="_blank" rel="noopener noreferrer" 
                       class="group bg-white/10 hover:bg-black backdrop-blur-md rounded-full p-3 md:p-4 transition-all duration-300 transform hover:scale-110 hover:shadow-xl border-2 border-white/20 hover:border-gray-400">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.18 6.18 0 0 0-1-.05A6.18 6.18 0 0 0 5 20.1a6.18 6.18 0 0 0 10.86-4.43v-7a8.28 8.28 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                        </svg>
                    </a>
                    @endif

                    @if($siteSettings->social_youtube ?? null)
                    <a href="{{ $siteSettings->social_youtube }}" target="_blank" rel="noopener noreferrer" 
                       class="group bg-white/10 hover:bg-red-600 backdrop-blur-md rounded-full p-3 md:p-4 transition-all duration-300 transform hover:scale-110 hover:shadow-xl border-2 border-white/20 hover:border-red-400">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif

                    @if($siteSettings->social_twitter ?? null)
                    <a href="{{ $siteSettings->social_twitter }}" target="_blank" rel="noopener noreferrer" 
                       class="group bg-white/10 hover:bg-blue-400 backdrop-blur-md rounded-full p-3 md:p-4 transition-all duration-300 transform hover:scale-110 hover:shadow-xl border-2 border-white/20 hover:border-blue-300">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

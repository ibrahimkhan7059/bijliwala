@extends('layouts.frontend')

@section('title', 'My Wishlist')

@push('styles')
<style>
    .wishlist-gradient {
        background: linear-gradient(135deg, #fff5e6 0%, #ffe4c4 25%, #ffd7a8 50%, #ffedd5 75%, #fff5e6 100%);
        background-attachment: fixed;
    }
</style>
@endpush

@section('content')
<div class="wishlist-gradient min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">My Wishlist</h1>
                    <p class="text-sm md:text-base text-gray-600 mt-1">Save your favorite products for later</p>
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

        @if($wishlistItems->count() > 0)
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                @foreach($wishlistItems as $wishlistItem)
                @php
                    $product = $wishlistItem->product;
                @endphp
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border-2 border-amber-200/50 overflow-hidden hover:shadow-xl transition-all group">
                    <!-- Product Image -->
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="block relative"
                       x-data="{
                            currentImage: 0,
                            totalImages: {{ is_array($product->images) ? count($product->images) : ($product->images ? 1 : 0) }},
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
                        <div class="aspect-square bg-gradient-to-br from-amber-50 to-orange-50 relative overflow-hidden">
                            @if(is_array($product->images) && count($product->images) > 0)
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
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
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
                            @elseif($product->images && method_exists($product->images, 'first') && $product->images->first())
                                <img src="{{ Storage::url($product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-2 left-2 flex flex-col gap-2">
                                @if($product->onSale)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold text-white shadow-lg"
                                          style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                        {{ $product->discountPercentage }}% OFF
                                    </span>
                                @endif
                                @if($product->featured)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold text-white shadow-lg"
                                          style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);">
                                        ⭐ Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category -->
                        @if($product->category)
                        <a href="{{ route('category.show', $product->category->slug) }}" class="text-xs font-semibold text-amber-600 hover:text-amber-700 mb-1 inline-block">
                            {{ $product->category->name }}
                        </a>
                        @endif

                        <!-- Product Name -->
                        <a href="{{ route('product.show', $product->slug) }}">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-amber-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <!-- Price -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg md:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                PKR {{ number_format($product->effectivePrice, 2) }}
                            </span>
                            @if($product->onSale && $product->original_price)
                                <span class="text-sm text-gray-500 line-through">
                                    PKR {{ number_format($product->original_price, 2) }}
                                </span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            @if($product->stock_quantity > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border border-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    In Stock
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-300">
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm font-semibold text-white rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                                        style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                            
                            <form action="{{ route('wishlist.destroy', $wishlistItem->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors border border-red-200"
                                        title="Remove from wishlist">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $wishlistItems->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-8 md:p-12 text-center">
                <div class="p-4 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Your Wishlist is Empty</h3>
                <p class="text-gray-600 mb-6">Start adding products to your wishlist to save them for later.</p>
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                   style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;">
                    Browse Products
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection



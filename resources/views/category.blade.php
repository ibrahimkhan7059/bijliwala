@extends('layouts.frontend')

@section('title', 'AJ Electric - ' . $category->name)

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-4 sm:mb-8 text-xs sm:text-sm overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 whitespace-nowrap">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('shop') }}" class="text-gray-500 hover:text-gray-700 whitespace-nowrap">Shop</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900 font-medium truncate">{{ $category->name }}</span>
        </nav>

        <!-- Category Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-sm sm:text-base text-gray-600">{{ $category->description }}</p>
            @endif
            <p class="text-xs sm:text-sm text-gray-500 mt-2">{{ $products->total() }} products found</p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Product Image -->
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="block aspect-square overflow-hidden bg-gray-100 relative group"
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
                                 class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-300">
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
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </a>

                    <!-- Product Info -->
                    <div class="p-4">
                        <a href="{{ route('product.show', $product->slug) }}" 
                           class="text-lg font-semibold text-gray-900 hover:text-indigo-600 line-clamp-2 mb-2">
                            {{ $product->name }}
                        </a>

                        <!-- Price -->
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-2xl font-bold text-gray-900">
                                Rs. {{ number_format($product->effective_price, 2) }}
                            </span>
                            @if($product->on_sale)
                                <span class="text-sm text-gray-500 line-through">
                                    Rs. {{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-semibold">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        @if($product->stock_quantity > 0)
                            <p class="text-sm text-green-600 mb-3">
                                <span class="font-medium">In Stock</span>
                            </p>
                        @else
                            <p class="text-sm text-red-600 mb-3 font-medium">Out of Stock</p>
                        @endif

                        <!-- Add to Cart Button -->
                        @if($product->stock_quantity > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-primary py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Products in this Category</h3>
                <p class="text-gray-600 mb-4">Check back later for new products</p>
                <a href="{{ route('shop') }}" class="btn-primary inline-block">
                    Browse All Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

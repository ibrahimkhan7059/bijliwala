@extends('layouts.frontend')

@section('title', 'Shop - All Products')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%); min-height: calc(100vh - 200px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">Shop All Products</h1>
            <p class="text-sm md:text-base text-gray-600">Browse our complete collection of electrical and solar products</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 md:gap-8">
            
            <!-- Mobile Filter Toggle -->
            <div class="lg:hidden mb-4" x-data="{ filtersOpen: false }">
                <button @click="filtersOpen = !filtersOpen" class="w-full bg-white rounded-xl shadow-md px-4 py-3 flex items-center justify-between font-semibold text-gray-900">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters & Sort
                    </span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <!-- Mobile Filters Panel -->
                <div x-show="filtersOpen" 
                     @click.away="filtersOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-4 bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 backdrop-blur-md rounded-xl shadow-xl p-6 border-2 border-orange-200">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter Products
                    </h3>
                    
                    <!-- Categories (Mobile) -->
                    @if($categories->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Categories
                        </h4>
                        <div class="space-y-2">
                            <a href="{{ route('shop') }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all {{ !request('category') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all {{ request('category') == $category->slug ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Sort Options (Mobile) -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                            Sort By
                        </h4>
                        <form action="{{ route('shop') }}" method="GET" id="sortFormMobile">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="sort" onchange="document.getElementById('sortFormMobile').submit()" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Desktop Sidebar Filters -->
            <aside class="hidden lg:block lg:w-72 flex-shrink-0">
                <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 backdrop-blur-md rounded-2xl shadow-xl p-6 sticky top-24 border-2 border-orange-200">
                    <h3 class="text-xl font-bold mb-6 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </h3>
                    
                    <!-- Categories (Desktop) -->
                    @if($categories->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Categories
                        </h4>
                        <div class="space-y-2">
                            <a href="{{ route('shop') }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all {{ !request('category') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all {{ request('category') == $category->slug ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Sort Options (Desktop) -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                            Sort By
                        </h4>
                        <form action="{{ route('shop') }}" method="GET" id="sortForm">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="sort" onchange="document.getElementById('sortForm').submit()" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                @if($products->count() > 0)
                    <!-- Results Count -->
                    <div class="mb-4 md:mb-6 flex items-center justify-between bg-gradient-to-r from-amber-50 via-orange-100 to-amber-50 rounded-xl shadow-lg px-4 py-3 border-2 border-orange-200">
                        <p class="text-sm md:text-base text-gray-700">
                            <span class="font-bold text-orange-600">{{ $products->total() }}</span> products found
                        </p>
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                        @foreach($products as $product)
                        <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 rounded-xl shadow-lg overflow-hidden card-hover group relative border-2 border-orange-200">
                            @if($product->on_sale)
                                <div class="absolute top-2 left-2 z-10 bg-gradient-to-r from-red-500 to-pink-600 text-white px-2 py-1 rounded-lg text-xs font-bold shadow-lg">
                                    -{{ $product->discount_percentage }}%
                                </div>
                            @endif
                            
                            <!-- Product Image with Hover Scroll -->
                            <div class="block aspect-square overflow-hidden bg-gray-100 relative">
                                @if($product->images && count($product->images) > 0)
                                    @if(count($product->images) > 1)
                                        <!-- Multiple Images - Hover Scroll -->
                                        <div x-data="{ 
                                            currentImage: 0, 
                                            totalImages: {{ count($product->images) }},
                                            isHovering: false,
                                            autoPlay: false,
                                            autoPlayInterval: null,
                                            nextImage() {
                                                this.currentImage = (this.currentImage + 1) % this.totalImages;
                                            },
                                            prevImage() {
                                                this.currentImage = this.currentImage === 0 ? this.totalImages - 1 : this.currentImage - 1;
                                            },
                                            startAutoPlay() {
                                                if (this.totalImages > 1) {
                                                    this.autoPlayInterval = setInterval(() => {
                                                        if (this.autoPlay) {
                                                            this.nextImage();
                                                        }
                                                    }, 1500); // Change image every 1.5 seconds
                                                }
                                            },
                                            clearAutoPlay() {
                                                if (this.autoPlayInterval) {
                                                    clearInterval(this.autoPlayInterval);
                                                    this.autoPlayInterval = null;
                                                }
                                            }
                                        }" 
                                        @mouseenter="isHovering = true; autoPlay = true; startAutoPlay();" 
                                        @mouseleave="isHovering = false; autoPlay = false; clearAutoPlay(); currentImage = 0;"
                                        class="w-full h-full relative group">
                                            
                                            <!-- Images -->
                                            @foreach($product->images as $index => $image)
                                            <a href="{{ route('product.show', $product->slug) }}" 
                                               x-show="currentImage === {{ $index }}"
                                               x-transition:enter="transition ease-out duration-300"
                                               x-transition:enter-start="opacity-0"
                                               x-transition:enter-end="opacity-100"
                                               class="absolute inset-0">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="{{ $product->name }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </a>
                                            @endforeach

                                            <!-- Navigation Arrows (show on hover) -->
                                            <div x-show="isHovering" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0"
                                                 x-transition:enter-end="opacity-100"
                                                 class="absolute inset-0 flex items-center justify-between p-2">
                                                <button @click.prevent="prevImage()" 
                                                        class="bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                </button>
                                                <button @click.prevent="nextImage()" 
                                                        class="bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Image Counter -->
                                            <div x-show="isHovering" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 class="absolute top-2 right-2 bg-black/60 text-white px-2 py-1 rounded-full text-xs">
                                                <span x-text="currentImage + 1"></span>/{{ count($product->images) }}
                                            </div>

                                            <!-- Auto-scroll Indicator -->
                                            <div x-show="!isHovering" 
                                                 class="absolute bottom-2 right-2 bg-blue-500/80 text-white px-2 py-1 rounded-full text-xs animate-pulse">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Hover
                                            </div>
                                        </div>
                                    @else
                                        <!-- Single Image -->
                                        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 md:w-24 h-16 md:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </a>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-3 md:p-4">
                                <!-- Category -->
                                @if($product->category)
                                <p class="text-xs text-orange-600 font-medium mb-1">{{ $product->category->name }}</p>
                                @endif

                                <!-- Product Name -->
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="text-sm md:text-base font-semibold text-gray-900 hover:text-orange-600 line-clamp-2 mb-2 block transition-colors">
                                    {{ $product->name }}
                                </a>

                                <!-- Price -->
                                <div class="flex items-center gap-1 md:gap-2 mb-2 md:mb-3 flex-wrap">
                                    <span class="text-lg md:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                        Rs. {{ number_format($product->effective_price) }}
                                    </span>
                                    @if($product->on_sale)
                                        <span class="text-xs md:text-sm text-gray-500 line-through">
                                            Rs. {{ number_format($product->price) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Stock Status -->
                                @if($product->stock_quantity > 0)
                                    <p class="text-xs md:text-sm text-green-600 mb-3 flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">In Stock</span>
                                    </p>
                                @else
                                    <p class="text-xs md:text-sm text-red-600 mb-3 flex items-center font-semibold">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        Out of Stock
                                    </p>
                                @endif

                                <!-- Add to Cart Button -->
                                @if($product->stock_quantity > 0)
                                    <form action="{{ route('cart.add') }}" method="POST">
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
                                    <button disabled class="w-full bg-gray-300 text-gray-600 py-2 px-3 rounded-lg text-xs md:text-sm font-semibold cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 md:mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-gradient-to-br from-orange-50 via-amber-100 to-yellow-50 rounded-2xl shadow-xl p-8 md:p-16 text-center border-2 border-orange-200">
                        <div class="w-20 h-20 md:w-24 md:h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">No Products Found</h3>
                        <p class="text-gray-600 mb-6 text-sm md:text-base">Try adjusting your filters or search terms to find what you're looking for</p>
                        <a href="{{ route('shop') }}" class="btn-primary inline-flex items-center py-3 px-6 rounded-lg font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            View All Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

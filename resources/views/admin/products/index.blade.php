@extends('admin.layout')

@section('title', 'Products Management')
@section('page-title', 'Products')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 md:p-6 mb-4 md:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex items-center space-x-2 sm:space-x-4 min-w-0 flex-1">
                <div class="p-1.5 sm:p-2 bg-blue-100 rounded-lg flex-shrink-0">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 md:h-6 md:w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 truncate">Products Management</h1>
                    <p class="text-xs sm:text-sm text-gray-600 hidden sm:block">Manage your product inventory</p>
                </div>
            </div>
            <div class="flex flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.products.create') }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent" 
                   style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Product</span>
                    <span class="sm:hidden">Add</span>
                </a>
                <button onclick="exportProducts()" 
                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                        style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Export</span>
                    <span class="sm:hidden">Export</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 animate-slide-in-up" x-data="{ showFilters: false }">
        <div class="border-b border-gray-200 px-3 sm:px-4 md:px-6 py-3 sm:py-4">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 truncate">Search & Filters</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 hidden sm:block">Find products quickly</p>
                </div>
                <button @click="showFilters = !showFilters" 
                        class="inline-flex items-center px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span x-text="showFilters ? 'Hide' : 'Show'">Show</span>
                </button>
            </div>
        </div>
        
        <div class="p-3 sm:p-4 md:p-6" x-show="showFilters" x-transition>
            <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-3 sm:space-y-4" id="filter-form">
                <!-- Search Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search Products</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="Search by name, SKU, description...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Additional Filters Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                            <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock (Low to High)</option>
                            <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock (High to Low)</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Status</label>
                        <select name="stock_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Stock</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price Range</label>
                        <select name="price_range" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Prices</option>
                            <option value="0-1000" {{ request('price_range') == '0-1000' ? 'selected' : '' }}>Under PKR 1,000</option>
                            <option value="1000-5000" {{ request('price_range') == '1000-5000' ? 'selected' : '' }}>PKR 1,000 - 5,000</option>
                            <option value="5000-10000" {{ request('price_range') == '5000-10000' ? 'selected' : '' }}>PKR 5,000 - 10,000</option>
                            <option value="10000-50000" {{ request('price_range') == '10000-50000' ? 'selected' : '' }}>PKR 10,000 - 50,000</option>
                            <option value="50000+" {{ request('price_range') == '50000+' ? 'selected' : '' }}>Above PKR 50,000</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Per Page</label>
                        <select name="per_page" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-2 sm:space-x-3 pt-3 sm:pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center justify-center px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors font-medium">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filters
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-3 sm:px-4 py-2 text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6 animate-slide-in-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-semibold text-gray-900">{{ $products->firstItem() ?? 0 }}</span> 
                    to <span class="font-semibold text-gray-900">{{ $products->lastItem() ?? 0 }}</span> 
                    of <span class="font-semibold text-gray-900">{{ $products->total() }}</span> products
                </div>
                @if(request()->hasAny(['search', 'category', 'status', 'sort', 'stock_status', 'price_range']))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Filtered Results
                    </span>
                @endif
            </div>
            <div class="flex gap-2">
            </div>
        </div>
    </div>

    <!-- Products Table/Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        @if($products->count() > 0)
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Products List</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs sm:text-sm text-gray-500 hidden sm:inline">View:</span>
                        <button onclick="toggleView('table')" id="table-view-btn" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                            </svg>
                        </button>
                        <button onclick="toggleView('grid')" id="grid-view-btn" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Cards View -->
            <div id="mobile-view" class="block md:hidden p-4 space-y-4">
                @foreach($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-12 w-12 rounded-lg object-cover flex-shrink-0 border border-gray-200">
                            @else
                            <div class="h-12 w-12 bg-gradient-to-r from-blue-100 to-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">SKU: {{ $product->sku }}</p>
                            </div>
                        </div>
                        @if($product->status === 'published' && $product->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2 flex-shrink-0">
                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                Active
                            </span>
                        @elseif($product->status === 'draft')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2 flex-shrink-0">Draft</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2 flex-shrink-0">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="space-y-2 mb-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Category:</span>
                            <span class="font-medium text-gray-900">{{ $product->category->name ?? 'No Category' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Price:</span>
                            <span class="font-medium text-gray-900">
                                @if($product->on_sale)
                                    <div class="flex flex-col items-end">
                                        <span class="text-red-600 font-bold">PKR {{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-gray-500 line-through text-xs">PKR {{ number_format($product->price, 2) }}</span>
                                        <span class="text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded mt-0.5 font-semibold">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    </div>
                                @else
                                    PKR {{ number_format($product->price, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Stock:</span>
                            <span class="font-medium {{ $product->stock_quantity > 10 ? 'text-green-600' : ($product->stock_quantity > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->manage_stock ? $product->stock_quantity . ' units' : 'Not managed' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.products.show', $product) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" 
                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Table View -->
            <div id="table-view" class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-12 w-12 rounded-lg object-cover mr-4 border border-gray-200">
                                    @else
                                    <div class="h-12 w-12 bg-gradient-to-r from-blue-100 to-orange-100 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $product->category->name ?? 'No Category' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($product->on_sale)
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-red-600">PKR {{ number_format($product->sale_price, 2) }}</span>
                                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-semibold">
                                                -{{ $product->discount_percentage }}%
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500 line-through">PKR {{ number_format($product->price, 2) }}</span>
                                    </div>
                                @else
                                    <span class="font-medium">PKR {{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->manage_stock)
                                    <span class="text-sm {{ $product->stock_quantity > 10 ? 'text-green-600' : ($product->stock_quantity > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $product->stock_quantity }} units
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Not managed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->status === 'published' && $product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                        Published
                                    </span>
                                @elseif($product->status === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors" 
                                        title="View Details">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded transition-colors" 
                                        title="Edit Product">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" 
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors" 
                                                title="Delete Product">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grid View -->
            <div id="grid-view" class="p-4 sm:p-6 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($products as $product)
                    <div class="bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-3">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                         alt="{{ $product->name }}" 
                                         class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                                @else
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                @endif
                                @if($product->status === 'published' && $product->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                        Published
                                    </span>
                                @elseif($product->status === 'published' && !$product->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Published
                                    </span>
                                @elseif($product->status === 'draft')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @elseif($product->status === 'out_of_stock')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($product->status) }}
                                </span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 mb-2">SKU: {{ $product->sku }}</p>
                            <p class="text-xs text-gray-600 mb-3">{{ $product->category->name ?? 'No Category' }}</p>
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    @if($product->on_sale)
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-red-600">PKR {{ number_format($product->sale_price, 2) }}</span>
                                            <span class="text-xs text-gray-500 line-through">PKR {{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-semibold">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">PKR {{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600">Stock: {{ $product->stock_quantity ?? 0 }}</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                        class="text-blue-600 hover:text-blue-700 transition-colors" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                        class="text-orange-600 hover:text-orange-700 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" 
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Professional Pagination -->
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-700">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="p-3 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['search', 'category', 'status', 'sort', 'stock_status', 'price_range']))
                        No products match your current filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first product to build your inventory.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'status', 'sort', 'stock_status', 'price_range']))
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors mr-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Clear Filters
                    </a>
                @endif
                <a href="{{ route('admin.products.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ request()->hasAny(['search', 'category', 'status', 'sort', 'stock_status', 'price_range']) ? 'Add New Product' : 'Add Your First Product' }}
                </a>
            </div>
        @endif
    </div>
</div>

<!-- JavaScript -->
<script>
// Auto-submit filters on change
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const filterInputs = filterForm.querySelectorAll('select, input');
    
    filterInputs.forEach(input => {
        if (input.name !== 'search') {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        }
    });
    
    // Search with debounce
    const searchInput = filterForm.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });
    }
});

// Toggle between table and grid view
function toggleView(viewType) {
    const tableView = document.getElementById('table-view');
    const gridView = document.getElementById('grid-view');
    const mobileView = document.getElementById('mobile-view');
    const tableBtn = document.getElementById('table-view-btn');
    const gridBtn = document.getElementById('grid-view-btn');
    
    // On mobile, always show mobile view
    if (window.innerWidth < 768) {
        if (mobileView) {
            mobileView.classList.remove('hidden');
            mobileView.classList.add('block');
        }
        if (tableView) tableView.classList.add('hidden');
        if (gridView) gridView.classList.add('hidden');
        return;
    }
    
    if (viewType === 'grid') {
        if (tableView) tableView.classList.add('hidden');
        if (gridView) gridView.classList.remove('hidden');
        if (mobileView) mobileView.classList.add('hidden');
        if (tableBtn) {
            tableBtn.classList.remove('text-blue-600');
            tableBtn.classList.add('text-gray-600');
        }
        if (gridBtn) {
            gridBtn.classList.remove('text-gray-600');
            gridBtn.classList.add('text-blue-600');
        }
        localStorage.setItem('products-view', 'grid');
    } else {
        if (gridView) gridView.classList.add('hidden');
        if (tableView) tableView.classList.remove('hidden');
        if (mobileView) mobileView.classList.add('hidden');
        if (gridBtn) {
            gridBtn.classList.remove('text-blue-600');
            gridBtn.classList.add('text-gray-600');
        }
        if (tableBtn) {
            tableBtn.classList.remove('text-gray-600');
            tableBtn.classList.add('text-blue-600');
        }
        localStorage.setItem('products-view', 'table');
    }
}

// Restore saved view preference
document.addEventListener('DOMContentLoaded', function() {
    // On mobile, always show mobile view
    if (window.innerWidth < 768) {
        const mobileView = document.getElementById('mobile-view');
        if (mobileView) {
            mobileView.classList.remove('hidden');
            mobileView.classList.add('block');
        }
        return;
    }
    
    const savedView = localStorage.getItem('products-view') || 'table';
    toggleView(savedView);
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
        const mobileView = document.getElementById('mobile-view');
        const tableView = document.getElementById('table-view');
        const gridView = document.getElementById('grid-view');
        if (mobileView) {
            mobileView.classList.remove('hidden');
            mobileView.classList.add('block');
        }
        if (tableView) tableView.classList.add('hidden');
        if (gridView) gridView.classList.add('hidden');
    } else {
        const savedView = localStorage.getItem('products-view') || 'table';
        toggleView(savedView);
    }
});

// Export products function
function exportProducts() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    window.location.href = '{{ route("admin.products.index") }}?' + params.toString();
}
</script>
@endsection

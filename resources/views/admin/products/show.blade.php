@extends('admin.layout')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $product->name }}</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Product details and information</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-md transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <button onclick="if(confirm('Are you sure you want to delete this product? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-medium rounded-md transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 border border-gray-300 hover:border-gray-400 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Professional Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Product Information</h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Complete details about this product</p>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="max-w-2xl mx-auto">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-blue-800">Product Details</h4>
                    </div>
                    <p class="text-xs text-blue-700 mt-1">Complete information about this product</p>
                </div>

                <div class="space-y-6">
                    <!-- Product Image -->
                    @if($product->images && count($product->images) > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-24 w-24 rounded-lg object-cover border border-gray-300">
                        </div>
                    </div>
                    @endif

                    <!-- Product Video -->
                    @if($product->video)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Video</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <video controls class="w-full max-w-md rounded-lg border border-gray-200">
                                <source src="{{ asset('storage/' . $product->video) }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    @endif

                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-medium">
                            {{ $product->name }}
                        </div>
                    </div>

                    <!-- SKU -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SKU</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 font-mono text-sm">
                            {{ $product->sku }}
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            @if($product->category)
                                <a href="{{ route('admin.categories.show', $product->category) }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                    {{ $product->category->name }}
                                </a>
                            @else
                                <span class="text-gray-500">No Category Assigned</span>
                            @endif
                        </div>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            @if($product->on_sale)
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl font-bold text-red-600">PKR {{ number_format($product->sale_price, 2) }}</span>
                                        <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                            SAVE {{ $product->discount_percentage }}%
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-base text-gray-500 line-through">PKR {{ number_format($product->price, 2) }}</span>
                                        <span class="text-sm text-gray-600">(Regular Price)</span>
                                    </div>
                                    <div class="pt-2 border-t border-gray-300">
                                        <span class="text-sm text-gray-700">
                                            You save: <span class="font-semibold text-red-600">PKR {{ number_format($product->price - $product->sale_price, 2) }}</span>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <span class="text-lg font-bold text-gray-900">PKR {{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="text-lg font-semibold {{ ($product->stock_quantity ?? 0) > 10 ? 'text-green-600' : (($product->stock_quantity ?? 0) > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->stock_quantity ?? 0 }} units
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg min-h-[80px]">
                            @if($product->description)
                                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                            @else
                                <span class="text-gray-500 italic">No description provided</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            @if($product->status === 'published')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                    Published
                                </span>
                            @elseif($product->status === 'draft')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @elseif($product->status === 'out_of_stock')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Out of Stock
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($product->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Featured Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Product</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->is_featured ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                @if($product->is_featured)
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                @else
                                    Not Featured
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Stock Management -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Management</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->manage_stock ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $product->manage_stock ? 'Stock Managed' : 'Stock Not Managed' }}
                            </span>
                        </div>
                    </div>

                    <!-- In Stock Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">In Stock Status</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->in_stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

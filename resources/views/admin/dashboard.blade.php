@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="animate-fade-in max-w-full">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="card p-4 sm:p-6 hover-lift animate-slide-in-right">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Products</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 sm:p-6 hover-lift animate-slide-in-right" style="animation-delay: 0.1s;">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 rounded-full bg-green-100 text-green-600 flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Active Products</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['active_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 sm:p-6 hover-lift animate-slide-in-right" style="animation-delay: 0.2s;">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 rounded-full bg-purple-100 text-purple-600 flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Customers</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 sm:p-6 hover-lift animate-slide-in-right" style="animation-delay: 0.3s;">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 rounded-full bg-orange-100 text-orange-600 flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Categories</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        <!-- Recent Products -->
        <div class="lg:col-span-2">
            <div class="card animate-slide-in-left">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">Recent Products</h3>
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    @if($recent_products->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_products as $product)
                            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                                    @else
                                        <div class="h-12 w-12 bg-gradient-to-r from-blue-100 to-orange-100 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->category->name ?? 'No Category' }}</p>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    @if($product->on_sale)
                                        <p class="text-sm font-medium text-red-600">PKR {{ number_format($product->sale_price, 2) }}</p>
                                        <p class="text-xs text-gray-500 line-through">PKR {{ number_format($product->price, 2) }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    @else
                                        <p class="text-sm font-medium text-gray-900">PKR {{ number_format($product->price, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.products.create') }}" class="btn-primary">
                                    Add Product
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card animate-slide-in-right">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.products.create') }}" class="w-full btn-primary text-center block hover-lift">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Product
                    </a>
                    <button class="w-full btn-secondary text-center block hover-lift">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Add Category
                    </button>
                    <a href="{{ route('home') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md text-center block transition-colors hover-lift">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Website
                    </a>
                </div>
            </div>

            <!-- System Status -->
            <div class="card animate-slide-in-right" style="animation-delay: 0.2s;">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">System Status</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Website Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                            Online
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Database</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                            Connected
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Storage</span>
                        <span class="text-sm font-medium text-gray-900">{{ round(disk_free_space('/') / 1073741824, 1) }}GB Free</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

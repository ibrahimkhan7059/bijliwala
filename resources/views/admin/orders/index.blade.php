@extends('admin.layout')

@section('title', 'Orders Management')
@section('page-title', 'Orders Management')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Orders Management</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Track and manage customer orders</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
                <button onclick="exportOrders()" 
                        class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent w-full sm:w-auto"
                        style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Export Orders</span>
                    <span class="sm:hidden">Export</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 animate-slide-in-up" x-data="{ showFilters: false }">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Search & Filters</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Find orders quickly with advanced filtering options</p>
                </div>
                <button @click="showFilters = !showFilters" 
                        class="inline-flex items-center px-3 py-2 text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors w-full sm:w-auto justify-center sm:justify-start">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'">Show Filters</span>
                </button>
            </div>
        </div>
        
        <div class="p-4 sm:p-6" x-show="showFilters" x-transition>
            <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4" id="filter-form">
                <!-- Search Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search Orders</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="Search by order ID, customer name, email...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Status</label>
                        <select name="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Payment Status</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                </div>

                <!-- Additional Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                            <option value="total_amount_desc" {{ request('sort') == 'total_amount_desc' ? 'selected' : '' }}>Amount (High to Low)</option>
                            <option value="total_amount_asc" {{ request('sort') == 'total_amount_asc' ? 'selected' : '' }}>Amount (Low to High)</option>
                            <option value="id_desc" {{ request('sort') == 'id_desc' ? 'selected' : '' }}>Order ID (High to Low)</option>
                            <option value="id_asc" {{ request('sort') == 'id_asc' ? 'selected' : '' }}>Order ID (Low to High)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                        <input type="date" 
                               name="date_from" 
                               value="{{ request('date_from') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                        <input type="date" 
                               name="date_to" 
                               value="{{ request('date_to') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Per Page</label>
                        <select name="per_page" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filters
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors font-medium">
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
                    Showing <span class="font-semibold text-gray-900">{{ $orders->firstItem() ?? 0 }}</span> 
                    to <span class="font-semibold text-gray-900">{{ $orders->lastItem() ?? 0 }}</span> 
                    of <span class="font-semibold text-gray-900">{{ $orders->total() }}</span> orders
                </div>
                @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Filtered Results
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        @if($orders->count() > 0)
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Orders List</h3>
            </div>

            <!-- Mobile Cards View -->
            <div class="block md:hidden p-4 space-y-4">
                @foreach($orders as $order)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="h-12 w-12 bg-gradient-to-r from-orange-100 to-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $order->orderItems->count() }} items</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 ml-2 flex-shrink-0">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 mb-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Customer:</span>
                            <span class="font-medium text-gray-900 truncate ml-2">{{ $order->user->name ?? 'Guest' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Amount:</span>
                            <span class="font-bold text-gray-900">PKR {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Payment:</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $order->payment_status_color }}-100 text-{{ $order->payment_status_color }}-800">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            View Details
                        </a>
                        @if($order->status === 'cancelled')
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline" 
                            onsubmit="return confirm('Are you sure you want to delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-r from-orange-100 to-red-100 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->orderItems->count() }} items</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                PKR {{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->payment_status_color }}-100 text-{{ $order->payment_status_color }}-800">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-xs">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors" 
                                        title="View Details">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        View
                                    </a>
                                    @if($order->status === 'cancelled')
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline" 
                                            onsubmit="return confirm('Are you sure you want to delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors" 
                                                    title="Delete Order">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Professional Pagination -->
            <div class="border-t border-gray-200 bg-gray-50 px-4 sm:px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs sm:text-sm text-gray-700">
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} results
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $orders->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="p-3 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                        No orders match your current filters. Try adjusting your search criteria.
                    @else
                        No orders have been placed yet. Orders will appear here once customers start placing them.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Clear Filters
                    </a>
                @endif
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

// Export orders function
function exportOrders() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    window.location.href = '{{ route("admin.orders.index") }}?' + params.toString();
}
</script>
@endsection

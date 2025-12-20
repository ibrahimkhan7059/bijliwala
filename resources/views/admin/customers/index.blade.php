@extends('admin.layout')

@section('title', 'Customers Management')
@section('page-title', 'Customers Management')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Customers Management</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Manage customer accounts and information</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.customers.create') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent w-full sm:w-auto" 
                   style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Customer</span>
                    <span class="sm:hidden">Add</span>
                </a>
                <button onclick="exportCustomers()" 
                        class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent w-full sm:w-auto"
                        style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
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
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Find customers quickly with advanced filtering options</p>
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
            <form method="GET" action="{{ route('admin.customers.index') }}" class="space-y-4" id="filter-form">
                <!-- Search Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search Customers</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="Search by name, email, phone...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Verification Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Email Verified</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Not Verified</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Orders Filter</label>
                        <select name="orders_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">All Customers</option>
                            <option value="has_orders" {{ request('orders_filter') == 'has_orders' ? 'selected' : '' }}>Has Orders</option>
                            <option value="no_orders" {{ request('orders_filter') == 'no_orders' ? 'selected' : '' }}>No Orders</option>
                            <option value="frequent" {{ request('orders_filter') == 'frequent' ? 'selected' : '' }}>Frequent (5+ Orders)</option>
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
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="email_asc" {{ request('sort') == 'email_asc' ? 'selected' : '' }}>Email (A-Z)</option>
                            <option value="email_desc" {{ request('sort') == 'email_desc' ? 'selected' : '' }}>Email (Z-A)</option>
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
                    <a href="{{ route('admin.customers.index') }}" 
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
                    Showing <span class="font-semibold text-gray-900">{{ $customers->firstItem() ?? 0 }}</span> 
                    to <span class="font-semibold text-gray-900">{{ $customers->lastItem() ?? 0 }}</span> 
                    of <span class="font-semibold text-gray-900">{{ $customers->total() }}</span> customers
                </div>
                @if(request()->hasAny(['search', 'status', 'orders_filter', 'date_from', 'date_to']))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Filtered Results
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        @if($customers->count() > 0)
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Customers List</h3>
            </div>

            <!-- Mobile Cards View -->
            <div class="block md:hidden p-4 space-y-4">
                @foreach($customers as $customer)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="h-12 w-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $customer->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">ID: {{ $customer->id }}</p>
                            </div>
                        </div>
                        @if($customer->email_verified_at)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2 flex-shrink-0">
                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2 flex-shrink-0">
                                <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></div>
                                Not Verified
                            </span>
                        @endif
                    </div>
                    
                    <div class="space-y-2 mb-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium text-gray-900 truncate ml-2 text-right">{{ $customer->email }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Phone:</span>
                            <span class="font-medium text-gray-900">{{ $customer->phone ?? 'No phone' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Orders:</span>
                            @if($customer->orders_count > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $customer->orders_count }} orders
                                </span>
                            @else
                                <span class="text-gray-500">No orders</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Joined:</span>
                            <span class="font-medium text-gray-900">{{ $customer->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.customers.show', $customer) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        @if($customer->orders_count === 0)
                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline" 
                            onsubmit="return confirm('Are you sure you want to delete this customer?')">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customers as $customer)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $customer->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->phone ?? 'No phone' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($customer->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></div>
                                        Not Verified
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($customer->orders_count > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $customer->orders_count }} orders
                                    </span>
                                @else
                                    <span class="text-gray-500">No orders</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->created_at->format('M d, Y') }}
                                <div class="text-xs">{{ $customer->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors" 
                                        title="View Details">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded transition-colors" 
                                        title="Edit Customer">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    @if($customer->orders_count === 0)
                                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline" 
                                            onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors" 
                                                    title="Delete Customer">
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
                            Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} results
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $customers->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="p-3 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['search', 'status', 'orders_filter', 'date_from', 'date_to']))
                        No customers match your current filters. Try adjusting your search criteria.
                    @else
                        No customers have registered yet. Customers will appear here once they start registering.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'orders_filter', 'date_from', 'date_to']))
                    <a href="{{ route('admin.customers.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors mr-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Clear Filters
                    </a>
                @endif
                <a href="{{ route('admin.customers.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Customer
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

// Export customers function
function exportCustomers() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    window.location.href = '{{ route("admin.customers.index") }}?' + params.toString();
}
</script>
@endsection

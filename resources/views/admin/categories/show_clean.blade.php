@extends('admin.layout')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 animate-slide-in-down">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                    <p class="text-sm text-gray-600">Category details and information</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 border border-gray-300 hover:border-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>
            </div>
        </div>
    </div>

    <!-- Professional Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Category Information</h3>
            <p class="text-sm text-gray-600 mt-1">View and manage category details</p>
        </div>
        
        <div class="p-6">
            <div class="max-w-2xl mx-auto">
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-purple-800">Category Details</h4>
                    </div>
                    <p class="text-xs text-purple-700 mt-1">Complete information about this category</p>
                </div>

                <div class="space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-medium">
                            {{ $category->name }}
                        </div>
                    </div>

                    <!-- URL Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">URL Slug</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 font-mono text-sm">
                            {{ $category->slug }}
                        </div>
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Parent Category</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-gray-500">Main Category (No Parent)</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg min-h-[80px]">
                            @if($category->description)
                                <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                            @else
                                <span class="text-gray-500 italic">No description provided</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subcategories Section (if exists) -->
    @if($category->children && $category->children->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 animate-slide-in-up">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Subcategories ({{ $category->children->count() }})</h3>
            <p class="text-sm text-gray-600 mt-1">Categories under this parent category</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($category->children as $child)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 transition-colors hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">
                                <a href="{{ route('admin.categories.show', $child) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $child->name }}
                                </a>
                            </h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $child->slug }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $child->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $child->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 animate-slide-in-up">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Actions</h3>
            <p class="text-sm text-gray-600 mt-1">Manage this category</p>
        </div>
        
        <div class="p-6">
            <div class="flex justify-center space-x-4">
                <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Product
                </a>
                
                <a href="{{ route('admin.categories.edit', $category) }}" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Category
                </a>
                
                <button onclick="if(confirm('Are you sure you want to delete this category? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }" 
                        class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 hover:border-red-400 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Category
                </button>
                
                <form id="delete-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

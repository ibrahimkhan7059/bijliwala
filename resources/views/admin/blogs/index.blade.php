@extends('admin.layout')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 md:p-6 mb-4 md:mb-6 animate-slide-in-down">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 sm:gap-4">
            <!-- Title and Stats -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-2">
                    <div class="p-1.5 sm:p-2 bg-red-100 rounded-lg flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 md:h-6 md:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 truncate">Blog Management</h1>
                        <p class="text-xs sm:text-sm text-gray-600 hidden sm:block">Manage YouTube video links</p>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-red-500 rounded-full"></div>
                        <span>{{ $blogs->total() }} Total</span>
                    </div>
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full"></div>
                        <span>{{ $blogs->where('status', 'published')->count() }} Published</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-row gap-2 sm:gap-3 w-full lg:w-auto">
                <a href="{{ route('admin.blogs.create') }}" 
                   class="flex-1 lg:flex-none inline-flex items-center justify-center px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent transform hover:scale-105"
                   style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Blog</span>
                    <span class="sm:hidden">Add</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 animate-slide-in-right" x-data="{ filtersOpen: {{ request()->hasAny(['search', 'status', 'sort']) ? 'true' : 'false' }} }">
        <!-- Filter Header -->
        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center space-x-2 sm:space-x-3 min-w-0 flex-1">
                    <div class="p-1 sm:p-1.5 bg-gray-100 rounded-md flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 truncate">Filters & Search</h3>
                    </div>
                    @if(request()->hasAny(['search', 'status', 'sort']))
                        <span class="inline-flex items-center px-1.5 sm:px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-blue-100 text-blue-800 flex-shrink-0">
                            {{ collect(['search', 'status', 'sort'])->filter(fn($key) => request($key))->count() }}
                        </span>
                    @endif
                </div>
                <button @click="filtersOpen = !filtersOpen" class="p-1.5 sm:p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg x-show="!filtersOpen" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="filtersOpen" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filter Form -->
        <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="p-3 sm:p-4 md:p-6">
            <form method="GET" action="{{ route('admin.blogs.index') }}" class="space-y-4 sm:space-y-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search Blogs</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search by title or description...">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                        <select name="sort" id="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="created_asc" {{ request('sort') === 'created_asc' ? 'selected' : '' }}>Oldest First</option>
                            <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                            <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                            <option value="views_desc" {{ request('sort') === 'views_desc' ? 'selected' : '' }}>Most Views</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="flex-1 px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                        Clear All
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Blogs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 animate-slide-in-left">
        @forelse($blogs as $blog)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Video Thumbnail -->
                @if($blog->youtube_thumbnail)
                    <div class="relative aspect-video bg-gray-100">
                        <img src="{{ $blog->youtube_thumbnail }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                @endif

                <!-- Content -->
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 flex-1">{{ $blog->title }}</h3>
                        @if($blog->status === 'published')
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 flex-shrink-0">
                                Published
                            </span>
                        @else
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 flex-shrink-0">
                                Draft
                            </span>
                        @endif
                    </div>

                    @if($blog->description)
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $blog->description }}</p>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center text-xs text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>{{ $blog->views }} views</span>
                        <span class="mx-2">•</span>
                        <span>{{ $blog->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" 
                           class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors text-center">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" 
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this blog?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No blogs found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first blog post.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Add Blog
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($blogs->hasPages())
        <div class="mt-6">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection


@extends('admin.layout')

@section('title', 'Create Blog')
@section('page-title', 'Create New Blog Post')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Create New Blog Post</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Add a new YouTube video to your blog</p>
                </div>
            </div>
            <a href="{{ route('admin.blogs.index') }}" 
               class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-gray-700 font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Back to Blogs</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </div>

    <!-- Professional Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Blog Information</h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Fill in the details below to create your blog post</p>
        </div>
        
        <form method="POST" action="{{ route('admin.blogs.store') }}" class="p-4 sm:p-6">
            @csrf
            <!-- Simple Single Column Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-red-800">Blog Information</h4>
                    </div>
                    <p class="text-xs text-red-700 mt-1">Add YouTube video links to share with your customers</p>
                </div>

                <div class="space-y-6">

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('title') border-red-500 @enderror"
                               placeholder="Enter video title...">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (Optional)
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('description') border-red-500 @enderror"
                                  placeholder="Enter video description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube URL -->
                    <div>
                        <label for="youtube_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            YouTube URL <span class="text-red-500">*</span>
                        </label>
                        <input type="url" 
                               name="youtube_url" 
                               id="youtube_url" 
                               value="{{ old('youtube_url') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('youtube_url') border-red-500 @enderror"
                               placeholder="https://www.youtube.com/watch?v=...">
                        @error('youtube_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Enter the full YouTube video URL</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('status') border-red-500 @enderror">
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Create Blog Post
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-all duration-300 text-center">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection



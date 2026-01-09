@extends('layouts.frontend')

@section('title', 'AJ Electric - Blog')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8 md:mb-12 text-center">
            <div class="inline-block bg-white/80 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-xl border-2 border-orange-200">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Our Blog</h1>
                </div>
                <p class="text-base md:text-lg text-gray-700">
                    Watch our latest videos, tutorials, and product guides
                </p>
            </div>
        </div>

        <!-- Videos Grid -->
        @if($blogs->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
            @foreach($blogs as $blog)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border-2 border-orange-200 hover:border-red-400 transition-all">
                <!-- Video Thumbnail -->
                @if($blog->youtube_thumbnail)
                <a href="{{ route('blog.show', $blog->slug) }}" class="block relative aspect-video bg-gray-100 overflow-hidden group">
                    <img src="{{ $blog->youtube_thumbnail }}" 
                         alt="{{ $blog->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/50 transition-colors">
                        <div class="bg-red-600 rounded-full p-4 md:p-6 shadow-2xl transform group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                    <!-- Duration Badge (if you want to add later) -->
                    <div class="absolute top-3 right-3 bg-black/80 text-white text-xs px-2 py-1 rounded">
                        YouTube
                    </div>
                </a>
                @endif

                <!-- Content -->
                <div class="p-4 md:p-5">
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-red-600 transition-colors">
                        <a href="{{ route('blog.show', $blog->slug) }}">
                            {{ $blog->title }}
                        </a>
                    </h3>

                    @if($blog->description)
                    <p class="text-sm md:text-base text-gray-600 mb-4 line-clamp-3">
                        {{ $blog->description }}
                    </p>
                    @endif

                    <!-- Stats and Action -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-xs md:text-sm text-gray-500 space-x-3">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>{{ $blog->views }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $blog->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <a href="{{ route('blog.show', $blog->slug) }}" 
                           class="inline-flex items-center px-3 md:px-4 py-2 bg-red-600 text-white text-xs md:text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                            <span>Watch Now</span>
                            <svg class="w-3 h-3 md:w-4 md:h-4 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="flex justify-center">
            {{ $blogs->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-12 bg-white rounded-3xl shadow-xl border-2 border-orange-200">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Videos Yet</h3>
            <p class="text-gray-600">Check back soon for new video content!</p>
        </div>
        @endif

    </div>
</div>
@endsection



@extends('layouts.frontend')

@section('title', $blog->title . ' - AJ Electric Blog')

@section('content')
<div class="py-4 md:py-8" style="background: linear-gradient(180deg, rgba(255,245,230,0.5) 0%, rgba(255,237,213,0.8) 50%, rgba(255,228,196,0.5) 100%);">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('blog.index') }}" 
               class="inline-flex items-center text-red-600 hover:text-red-700 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Blog
            </a>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-2 border-orange-200">
            
            <!-- Video Player Section -->
            @if($blog->youtube_video_id)
            <div class="relative w-full" style="padding-bottom: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full"
                    src="https://www.youtube.com/embed/{{ $blog->youtube_video_id }}?rel=0&modestbranding=1" 
                    title="{{ $blog->title }}"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>
            @endif

            <!-- Content Section -->
            <div class="p-6 md:p-8">
                
                <!-- Title -->
                <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    {{ $blog->title }}
                </h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 md:gap-6 text-sm md:text-base text-gray-600 mb-6 pb-6 border-b-2 border-gray-100">
                    <!-- Views -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="font-semibold">{{ number_format($blog->views) }} views</span>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $blog->created_at->format('F d, Y') }}</span>
                    </div>

                    <!-- Watch on YouTube Link -->
                    <div class="ml-auto">
                        <a href="{{ $blog->youtube_url }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            Watch on YouTube
                        </a>
                    </div>
                </div>

                <!-- Description -->
                @if($blog->description)
                <div class="prose prose-lg max-w-none">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">About this video</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $blog->description }}
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- Related Videos Section (Optional - can be added later) -->
        <!-- You can add a section here to show other related blog videos -->

    </div>
</div>
@endsection


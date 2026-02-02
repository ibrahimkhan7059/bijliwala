@extends('admin.layout')

@section('title', 'Edit Blog')
@section('page-title', 'Edit Blog Post')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 300px;
        font-size: 16px;
    }
</style>
@endpush

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Blog Post</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Update your blog post details</p>
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
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Update the details below to edit your blog post</p>
        </div>
        
        <form id="blog-form" method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="p-4 sm:p-6">
            @csrf
            @method('PUT')
            <!-- Simple Single Column Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-red-800">Blog Information</h4>
                    </div>
                    <p class="text-xs text-red-700 mt-1">Update the YouTube video details</p>
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
                               value="{{ old('title', $blog->title) }}"
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
                        <div id="editor" class="bg-white border border-gray-300 rounded-lg min-h-[300px] @error('description') border-red-500 @enderror"></div>
                        <textarea name="description" id="description" style="display:none;">{{ old('description', $blog->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">✏️ Use the formatting toolbar above to add headings, bullets, bold text, etc. Click the bullet icon for lists!</p>
                    </div>

                    <!-- YouTube URL -->
                    <div>
                        <label for="youtube_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            YouTube URL <span class="text-red-500">*</span>
                        </label>
                        <input type="url" 
                               name="youtube_url" 
                               id="youtube_url" 
                               value="{{ old('youtube_url', $blog->youtube_url) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('youtube_url') border-red-500 @enderror"
                               placeholder="https://www.youtube.com/watch?v=...">
                        @error('youtube_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Enter the full YouTube video URL</p>
                    </div>

                    <!-- Video Preview -->
                    @if($blog->embed_url)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Video</label>
                            <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                <iframe src="{{ $blog->embed_url }}" 
                                        class="w-full h-full" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('status') border-red-500 @enderror">
                            <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stats -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Views</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $blog->views }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Created</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $blog->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Update Blog Post
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

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.querySelector('textarea[name=description]');
    var existingContent = textarea ? textarea.value.trim() : '';

    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Enter video description with formatting...'
    });

    if (existingContent) {
        var htmlContent = existingContent.includes('<')
            ? existingContent
            : '<p>' + existingContent.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>') + '</p>';
        quill.clipboard.dangerouslyPasteHTML(htmlContent);
    }

    var form = document.getElementById('blog-form') || (textarea ? textarea.closest('form') : null);
    if (form) {
        form.addEventListener('submit', function() {
            var content = quill.root.innerHTML;
            if (content === '<p><br></p>' || content === '<p></p>') {
                content = '';
            }
            if (textarea) {
                textarea.value = content;
            }
        });
    }
});
</script>
@endpush

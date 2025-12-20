@extends('admin.layout')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Create New Category</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Add a new category to organize your products</p>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}" 
               class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-gray-700 font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Back to Categories</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </div>

    <!-- Professional Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Category Information</h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Fill in the details below to create your category</p>
        </div>
        
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="p-4 sm:p-6">
            @csrf
            <!-- Simple Single Column Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-blue-800">Category Information</h4>
                    </div>
                    <p class="text-xs text-blue-700 mt-1">Fill in the basic details to create your category</p>
                </div>

                <div class="space-y-6">

                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                               placeholder="Enter category name..."
                               onkeyup="generateSlug();">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Auto-Generated Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                            URL Slug
                        </label>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('slug') border-red-500 @enderror"
                               placeholder="auto-generated-from-name">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate</p>
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Parent Category
                        </label>
                        <select name="parent_id" id="parent_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('parent_id') border-red-500 @enderror">
                            <option value="">Main Category (No Parent)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Optional - select parent category</p>
                    </div>

                    <!-- Category Image -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Image
                        </label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-shrink-0 w-24 h-24 border-2 border-gray-300 border-dashed rounded-lg flex items-center justify-center bg-gray-50 overflow-hidden" id="image-preview">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       onchange="previewImage(this)"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Upload category image (JPG, PNG, GIF, WebP - Max 5MB)</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('description') border-red-500 @enderror"
                                  placeholder="Brief description (optional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', 1) == 1 ? 'checked' : '' }}
                                       class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="is_active" 
                                       value="0"
                                       {{ old('is_active', 1) == 0 ? 'checked' : '' }}
                                       class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Inactive</span>
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Inactive categories won't be visible on website</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="col-span-full pt-6 mt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.categories.index') }}" 
                        class="inline-flex items-center px-6 py-3 text-gray-700 font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 text-white font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent focus:outline-none focus:ring-4 focus:ring-green-200"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

<script>
// Auto-generate slug from name
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')  // Remove special characters
        .replace(/\s+/g, '-')         // Replace spaces with hyphens
        .replace(/-+/g, '-')          // Replace multiple hyphens with single
        .replace(/^-|-$/g, '');       // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
}

// Preview image before upload
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg">`;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = `
            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        `;
    }
}
</script>
@endsection

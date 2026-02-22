@extends('admin.layout')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@push('styles')
<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

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
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Add New Product</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Create a new product in your inventory</p>
                </div>
            </div>
            <a href="{{ route('admin.products.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 border border-gray-300 hover:border-gray-400 text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Back to Products</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Product Information</h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Fill in the details below to create a new product</p>
        </div>
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
            @csrf
            
            <div class="max-w-2xl mx-auto">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-green-800">Product Details</h4>
                    </div>
                    <p class="text-xs text-green-700 mt-1">Enter the basic information for your new product</p>
                </div>

                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('name') border-red-500 @enderror"
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">
                            SKU (Stock Keeping Unit) <span class="text-gray-500 text-xs">(Optional)</span>
                        </label>
                        <input type="text" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('sku') border-red-500 @enderror"
                               placeholder="Enter unique SKU">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ (old('category_id', request('category')) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Regular Price (PKR) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('price') border-red-500 @enderror"
                               placeholder="0.00"
                               oninput="calculateDiscount()"
                               required>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Price (Discount) -->
                    <div>
                        <label for="sale_price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale Price (PKR) <span class="text-gray-500 text-xs">(Optional - Leave empty for no discount)</span>
                        </label>
                        <input type="number" 
                               id="sale_price" 
                               name="sale_price" 
                               value="{{ old('sale_price') }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('sale_price') border-red-500 @enderror"
                               placeholder="0.00"
                               oninput="calculateDiscount()">
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Discount Display -->
                        <div id="discount-display" class="mt-2 hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <p class="text-sm text-green-800">
                                    <span class="font-semibold">Discount:</span> 
                                    <span id="discount-percentage" class="font-bold">0%</span> 
                                    <span class="text-gray-600">off</span>
                                </p>
                                <p class="text-xs text-green-700 mt-1">
                                    You save: <span id="discount-amount" class="font-semibold">PKR 0.00</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="stock_quantity" 
                               name="stock_quantity" 
                               value="{{ old('stock_quantity', 0) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('stock_quantity') border-red-500 @enderror"
                               placeholder="0"
                               required>
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description <span class="text-gray-500 text-xs">(Optional)</span>
                        </label>
                        <div id="description-editor" style="min-height: 200px;" class="bg-white border border-gray-300 rounded-lg @error('description') border-red-500 @enderror"></div>
                        <textarea id="description" 
                                  name="description" 
                                  class="hidden">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Images -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Images
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-green-400 transition-colors" id="image-upload-area">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <label for="images" class="cursor-pointer">
                                        <span class="inline-flex items-center px-6 py-3 text-sm rounded-lg transition-all duration-300 image-upload-btn">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Choose Images
                                        </span>
                                        <input type="file" 
                                               id="images" 
                                               name="images[]" 
                                               multiple
                                               accept="image/*"
                                               class="sr-only"
                                               onchange="handleImageSelect(this)">
                                    </label>
                                    <p class="text-sm text-gray-500 mt-2">Upload up to 5 product images (PNG, JPG, JPEG, WEBP up to 5MB each)</p>
                                </div>
                            </div>
                        </div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Image Preview Area -->
                        <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>

                        <!-- Product Video -->
                        <div class="mt-6">
                            <label for="video" class="block text-sm font-semibold text-gray-700 mb-2">
                                Product Video (Optional)
                            </label>
                            <input type="file"
                                   id="video"
                                   name="video"
                                   accept="video/mp4,video/webm,video/ogg"
                                   class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Max 30 seconds recommended • MP4/WEBM/OGG up to 50MB</p>
                            @error('video')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('status') border-red-500 @enderror"
                                required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Product Variations Section -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                <h4 class="text-sm font-semibold text-blue-800">Product Variations (Optional)</h4>
                            </div>
                            <button type="button" 
                                    onclick="addVariation()"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Variation
                            </button>
                        </div>
                        <p class="text-xs text-blue-700 mt-2">Add variations like Size, Length, Wattage, etc. Each variation can have its own price and stock.</p>
                    </div>

                    <div id="variations-container" class="space-y-4">
                        <!-- Variations will be added here dynamically -->
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 hover:border-gray-400 transition-all duration-300 shadow-sm hover:shadow-md">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-4 rounded-lg transition-all duration-300 submit-btn focus:outline-none focus:ring-4 focus:ring-green-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles for Buttons -->
<style>
.btn-primary {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
    color: white !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}

.btn-primary:hover {
    background-color: #1d4ed8 !important;
    border-color: #1d4ed8 !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    transform: translateY(-1px);
}

.image-upload-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    color: white !important;
    border: 2px solid transparent !important;
    font-weight: 600 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3) !important;
}

.image-upload-btn:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 12px -2px rgba(59, 130, 246, 0.4) !important;
}

.submit-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
    border: 2px solid transparent !important;
    font-weight: 600 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3) !important;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 12px -2px rgba(16, 185, 129, 0.4) !important;
}
</style>

<!-- JavaScript for Image Upload -->
<script>
let selectedImages = [];

function handleImageSelect(input) {
    let files = Array.from(input.files);
    const previewArea = document.getElementById('image-preview');
    
    // Clear previous previews
    previewArea.innerHTML = '';
    selectedImages = [];
    
    if (files.length > 0) {
        if (files.length > 5) {
            alert('You can upload a maximum of 5 images.');
            files = files.slice(0, 5);
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;
        }
        previewArea.classList.remove('hidden');
        
        files.forEach((file, index) => {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert(`${file.name} is too large. Maximum size is 5MB.`);
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert(`${file.name} is not a valid image file.`);
                return;
            }
            
            selectedImages.push(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageContainer = document.createElement('div');
                imageContainer.className = 'relative group border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow';
                
                imageContainer.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Preview ${index + 1}" 
                         class="w-full h-32 object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button type="button" 
                                onclick="removeImage(${index})" 
                                class="text-white hover:text-red-300 transition-colors p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-2 bg-gray-50">
                        <p class="text-xs text-gray-600 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                `;
                
                previewArea.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewArea.classList.add('hidden');
    }
}

function removeImage(index) {
    // Remove from selectedImages array
    selectedImages.splice(index, 1);
    
    // Update the file input with remaining files
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    
    selectedImages.forEach(file => {
        dt.items.add(file);
    });
    
    input.files = dt.files;
    
    // Refresh preview
    handleImageSelect(input);
}

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const imageInput = document.getElementById('images');
    
    form.addEventListener('submit', function(e) {
        console.log('Form submitting with images:', imageInput.files.length);
        
        // Ensure multiple files are properly set
        if (selectedImages.length > 0 && imageInput.files.length !== selectedImages.length) {
            const dt = new DataTransfer();
            selectedImages.forEach(file => {
                dt.items.add(file);
            });
            imageInput.files = dt.files;
        }
        
        console.log('Final image count:', imageInput.files.length);
    });
});

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('image-upload-area');
    const imageInput = document.getElementById('images');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        uploadArea.classList.add('border-green-400', 'bg-green-50');
    }
    
    function unhighlight(e) {
        uploadArea.classList.remove('border-green-400', 'bg-green-50');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        imageInput.files = files;
        handleImageSelect(imageInput);
    }

});

// Calculate and display discount
function calculateDiscount() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
    const discountDisplay = document.getElementById('discount-display');
    const discountPercentage = document.getElementById('discount-percentage');
    const discountAmount = document.getElementById('discount-amount');
    
    if (salePrice > 0 && salePrice < price) {
        const discount = ((price - salePrice) / price) * 100;
        const savings = price - salePrice;
        
        discountPercentage.textContent = Math.round(discount) + '%';
        discountAmount.textContent = 'PKR ' + savings.toFixed(2);
        discountDisplay.classList.remove('hidden');
    } else {
        discountDisplay.classList.add('hidden');
    }
}

// Calculate discount on page load if values exist
document.addEventListener('DOMContentLoaded', function() {
    calculateDiscount();
});
</script>

<!-- Quill.js JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
// Initialize Quill Editor for Description
var quillEditor;
document.addEventListener('DOMContentLoaded', function() {
    quillEditor = new Quill('#description-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Enter product description with formatting...'
    });

    // Load existing content if any (for old() values)
    var existingContent = document.querySelector('#description').value;
    if (existingContent) {
        quillEditor.root.innerHTML = existingContent;
    }

    // Sync Quill content with hidden textarea on form submit
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Sync content before submission
            var descriptionField = document.querySelector('#description');
            var content = quillEditor.root.innerHTML;
            
            // If editor is empty (only contains <p><br></p>), set empty string
            if (quillEditor.getText().trim() === '') {
                descriptionField.value = '';
            } else {
                descriptionField.value = content;
            }
            
            console.log('Description being submitted:', descriptionField.value);
        });
    }
    
    // Also sync on any text change (backup method)
    quillEditor.on('text-change', function() {
        var descriptionField = document.querySelector('#description');
        var content = quillEditor.root.innerHTML;
        
        if (quillEditor.getText().trim() === '') {
            descriptionField.value = '';
        } else {
            descriptionField.value = content;
        }
    });
});
</script>

<script>
// Product Variations Management
let variationCount = 0;

function addVariation() {
    variationCount++;
    const container = document.getElementById('variations-container');
    const variationHtml = `
        <div class="variation-item bg-white border-2 border-gray-200 rounded-lg p-6 relative" data-variation="${variationCount}">
            <button type="button" 
                    onclick="removeVariation(this)"
                    class="absolute top-3 right-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Variation Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Variation Type <span class="text-red-500">*</span>
                    </label>
                    <select name="variations[${variationCount}][type]" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        <option value="">Select Type</option>
                        <option value="Size">Size</option>
                        <option value="Length">Length</option>
                        <option value="Wattage">Wattage</option>
                        <option value="Voltage">Voltage</option>
                        <option value="Capacity">Capacity</option>
                        <option value="Weight">Weight</option>
                        <option value="Color">Color</option>
                        <option value="Material">Material</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Variation Name/Value -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Value/Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="variations[${variationCount}][name]" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="e.g., 1 Meter, 100W, Large"
                           required>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Price (PKR) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="variations[${variationCount}][price]" 
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="0.00"
                           required>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="variations[${variationCount}][stock_quantity]" 
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="0"
                           required>
                </div>

                <!-- SKU (Optional) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SKU <span class="text-gray-500 text-xs">(Optional)</span>
                    </label>
                    <input type="text" 
                           name="variations[${variationCount}][sku]" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Unique SKU for this variation">
                </div>

                <!-- Is Active -->
                <div class="flex items-center pt-8">
                    <input type="checkbox" 
                           name="variations[${variationCount}][is_active]" 
                           value="1"
                           checked
                           id="variation_active_${variationCount}"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="variation_active_${variationCount}" class="ml-2 text-sm font-medium text-gray-700">
                        Active
                    </label>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', variationHtml);
}

function removeVariation(button) {
    if (confirm('Are you sure you want to remove this variation?')) {
        button.closest('.variation-item').remove();
    }
}
</script>

@endsection

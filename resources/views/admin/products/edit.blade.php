@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Product</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Update product information and details</p>
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

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Product Information</h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Update the details below to modify the product</p>
        </div>
        
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
            @csrf
            @method('PUT')
            
            <div class="max-w-2xl mx-auto">
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-orange-800">Update Product Details</h4>
                    </div>
                    <p class="text-xs text-orange-700 mt-1">Modify the information for this product</p>
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
                               value="{{ old('name', $product->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('name') border-red-500 @enderror"
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
                               value="{{ old('sku', $product->sku) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('sku') border-red-500 @enderror"
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
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
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('price') border-red-500 @enderror"
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
                               value="{{ old('sale_price', $product->sale_price) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('sale_price') border-red-500 @enderror"
                               placeholder="0.00"
                               oninput="calculateDiscount()">
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Discount Display -->
                        <div id="discount-display" class="mt-2 {{ old('sale_price', $product->sale_price) && old('sale_price', $product->sale_price) < old('price', $product->price) ? '' : 'hidden' }}">
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
                               value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('stock_quantity') border-red-500 @enderror"
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
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('description') border-red-500 @enderror"
                                  placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Images -->
                    @if($product->images && count($product->images) > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Images
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                            @foreach($product->images as $image)
                                <div class="relative group border border-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Product Image" 
                                         class="w-full h-32 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-sm">Current Image</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500">Upload new images below to replace current ones</p>
                    </div>
                    @endif

                    <!-- Product Images -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Images
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-orange-400 transition-colors" id="image-upload-area">
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
                                            Choose New Images
                                        </span>
                                        <input type="file" 
                                               id="images" 
                                               name="images[]" 
                                               multiple
                                               accept="image/*"
                                               class="sr-only"
                                               onchange="handleImageSelect(this)">
                                    </label>
                                    <p class="text-sm text-gray-500 mt-2">Upload new images to replace existing ones (PNG, JPG, JPEG up to 5MB each)</p>
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
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('status') border-red-500 @enderror"
                                required>
                            <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles for Buttons -->
<style>
.image-upload-btn {
    background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%) !important;
    color: white !important;
    border: 2px solid transparent !important;
    font-weight: 600 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.3) !important;
}

.image-upload-btn:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 12px -2px rgba(234, 88, 12, 0.4) !important;
}
</style>

<!-- JavaScript for Image Upload -->
<script>
let selectedImages = [];

function handleImageSelect(input) {
    const files = Array.from(input.files);
    const previewArea = document.getElementById('image-preview');
    
    // Clear previous previews
    previewArea.innerHTML = '';
    selectedImages = [];
    
    if (files.length > 0) {
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
        uploadArea.classList.add('border-orange-400', 'bg-orange-50');
    }
    
    function unhighlight(e) {
        uploadArea.classList.remove('border-orange-400', 'bg-orange-50');
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
@endsection

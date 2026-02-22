<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status Filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive');
            }
        }

        // Stock Status Filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 10);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '<=', 0);
                    break;
            }
        }

        // Price Range Filter
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-1000':
                    $query->where('price', '>=', 0)->where('price', '<=', 1000);
                    break;
                case '1000-5000':
                    $query->where('price', '>', 1000)->where('price', '<=', 5000);
                    break;
                case '5000-10000':
                    $query->where('price', '>', 5000)->where('price', '<=', 10000);
                    break;
                case '10000-50000':
                    $query->where('price', '>', 10000)->where('price', '<=', 50000);
                    break;
                case '50000+':
                    $query->where('price', '>', 50000);
                    break;
            }
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock':
                $query->orderBy('stock_quantity', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock_quantity', 'desc');
                break;
            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_desc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        // Handle CSV Export
        if ($request->get('export') === 'csv') {
            return $this->exportProductsCSV($query);
        }

        $products = $query->paginate($perPage);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Export products to CSV
     */
    private function exportProductsCSV($query)
    {
        $products = $query->get();
        
        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Name', 'SKU', 'Category', 'Price', 'Stock Quantity', 
                'Status', 'Created At', 'Updated At'
            ]);
            
            // CSV Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->category->name ?? 'No Category',
                    $product->price,
                    $product->stock_quantity ?? 0,
                    $product->status,
                    $product->created_at->format('Y-m-d H:i:s'),
                    $product->updated_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|unique:products,sku|max:100',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'manage_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'required|in:draft,published,out_of_stock',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
            'variations' => 'nullable|array',
            'variations.*.type' => 'required_with:variations|string|max:50',
            'variations.*.name' => 'required_with:variations|string|max:255',
            'variations.*.price' => 'required_with:variations|numeric|min:0',
            'variations.*.stock_quantity' => 'required_with:variations|integer|min:0',
            'variations.*.sku' => 'nullable|string|max:100|unique:product_variations,sku',
            'variations.*.is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['in_stock'] = $validated['stock_quantity'] > 0;

        // Handle image uploads
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            // Debug: Check how many files received
            \Log::info('Images received: ' . count($request->file('images')));
            
            // Create directory if it doesn't exist
            $uploadPath = storage_path('app/public/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $filename);
                $uploadedImages[] = 'products/' . $filename;
                \Log::info('Image uploaded: ' . $filename);

                // Windows-compatible public copy for display
                $publicPath = public_path('storage/products');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                @copy($uploadPath . DIRECTORY_SEPARATOR . $filename, $publicPath . DIRECTORY_SEPARATOR . $filename);
            }
        } else {
            \Log::info('No images received in request');
        }
        $validated['images'] = $uploadedImages;

        // Handle video upload (optional)
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoPath = storage_path('app/public/products/videos');
            if (!file_exists($videoPath)) {
                mkdir($videoPath, 0755, true);
            }
            $videoFilename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move($videoPath, $videoFilename);
            $validated['video'] = 'products/videos/' . $videoFilename;

            $publicVideoPath = public_path('storage/products/videos');
            if (!file_exists($publicVideoPath)) {
                mkdir($publicVideoPath, 0755, true);
            }
            @copy($videoPath . DIRECTORY_SEPARATOR . $videoFilename, $publicVideoPath . DIRECTORY_SEPARATOR . $videoFilename);
        }

        // Create product
        $product = Product::create($validated);

        // Handle product variations
        if ($request->has('variations') && is_array($request->variations)) {
            foreach ($request->variations as $index => $variationData) {
                $product->variations()->create([
                    'type' => $variationData['type'],
                    'name' => $variationData['name'],
                    'price' => $variationData['price'],
                    'stock_quantity' => $variationData['stock_quantity'],
                    'sku' => $variationData['sku'] ?? null,
                    'is_active' => isset($variationData['is_active']) ? true : false,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'manage_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'required|in:draft,published,out_of_stock',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
            'variations' => 'nullable|array',
            'variations.*.type' => 'required_with:variations|string|max:50',
            'variations.*.name' => 'required_with:variations|string|max:255',
            'variations.*.price' => 'required_with:variations|numeric|min:0',
            'variations.*.stock_quantity' => 'required_with:variations|integer|min:0',
            'variations.*.sku' => 'nullable|string|max:100',
            'variations.*.is_active' => 'nullable|boolean',
        ]);

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        $validated['in_stock'] = $validated['stock_quantity'] > 0;

        // Handle image uploads for update
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    $oldImagePath = storage_path('app/public/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $oldPublicPath = public_path('storage/' . $oldImage);
                    if (file_exists($oldPublicPath)) {
                        unlink($oldPublicPath);
                    }
                }
            }

            // Upload new images
            $uploadedImages = [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $storageDir = storage_path('app/public/products');
                if (!file_exists($storageDir)) {
                    mkdir($storageDir, 0755, true);
                }
                $image->move($storageDir, $filename);
                $uploadedImages[] = 'products/' . $filename;

                $publicPath = public_path('storage/products');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                @copy($storageDir . DIRECTORY_SEPARATOR . $filename, $publicPath . DIRECTORY_SEPARATOR . $filename);
            }
            $validated['images'] = $uploadedImages;
        }

        // Handle video upload for update
        if ($request->hasFile('video')) {
            if ($product->video) {
                $oldVideoPath = storage_path('app/public/' . $product->video);
                if (file_exists($oldVideoPath)) {
                    unlink($oldVideoPath);
                }
                $oldPublicVideoPath = public_path('storage/' . $product->video);
                if (file_exists($oldPublicVideoPath)) {
                    unlink($oldPublicVideoPath);
                }
            }

            $video = $request->file('video');
            $videoPath = storage_path('app/public/products/videos');
            if (!file_exists($videoPath)) {
                mkdir($videoPath, 0755, true);
            }
            $videoFilename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move($videoPath, $videoFilename);
            $validated['video'] = 'products/videos/' . $videoFilename;

            $publicVideoPath = public_path('storage/products/videos');
            if (!file_exists($publicVideoPath)) {
                mkdir($publicVideoPath, 0755, true);
            }
            @copy($videoPath . DIRECTORY_SEPARATOR . $videoFilename, $publicVideoPath . DIRECTORY_SEPARATOR . $videoFilename);
        }

        $product->update($validated);

        // Handle product variations update
        if ($request->has('variations')) {
            // Delete old variations
            $product->variations()->delete();
            
            // Create new variations
            foreach ($request->variations as $index => $variationData) {
                $product->variations()->create([
                    'type' => $variationData['type'],
                    'name' => $variationData['name'],
                    'price' => $variationData['price'],
                    'stock_quantity' => $variationData['stock_quantity'],
                    'sku' => $variationData['sku'] ?? null,
                    'is_active' => isset($variationData['is_active']) ? true : false,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}

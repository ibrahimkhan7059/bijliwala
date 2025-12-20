<?php

use App\Models\Product;

// Debug route to check product images
Route::get('/debug/product-images', function() {
    $product = Product::first();
    
    if (!$product) {
        return response()->json(['message' => 'No products found']);
    }
    
    return response()->json([
        'product_name' => $product->name,
        'images_raw' => $product->getRawOriginal('images'),
        'images_casted' => $product->images,
        'images_type' => gettype($product->images),
        'images_is_array' => is_array($product->images),
        'images_count' => $product->images ? count($product->images) : 0,
    ]);
});

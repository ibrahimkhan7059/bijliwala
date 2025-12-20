<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\Category;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check if any categories exist
    $count = Category::count();
    echo "Total categories: $count\n";
    
    if ($count > 0) {
        $categories = Category::take(3)->get(['id', 'name', 'slug']);
        foreach ($categories as $cat) {
            echo "ID: {$cat->id} - Name: {$cat->name} - Slug: {$cat->slug}\n";
        }
    } else {
        // Create a test category
        $cat = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test category for debugging',
            'is_active' => true
        ]);
        echo "Created test category: ID={$cat->id}, Name={$cat->name}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

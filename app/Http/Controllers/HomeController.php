<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the homepage
     */
    public function index()
    {
        $featuredProducts = Product::active()->featured()->latest()->take(8)->get();
        $saleProducts = Product::active()->onSale()->latest()->take(8)->get();
        $categories = Category::active()->root()->orderBy('sort_order')->get();

        return view('home', compact('featuredProducts', 'saleProducts', 'categories'));
    }

    /**
     * Show the shop page
     */
    public function shop(Request $request)
    {
        $query = Product::active()->with('category');

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::active()->root()->orderBy('sort_order')->get();

        return view('shop', compact('products', 'categories'));
    }

    /**
     * Show a single product
     */
    public function product($slug)
    {
        $product = Product::active()->where('slug', $slug)->with(['category', 'activeVariations'])->firstOrFail();
        
        // Related products from same category
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    /**
     * Show products by category
     */
    public function category($slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();
        
        $products = Product::active()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('category', compact('category', 'products'));
    }

    /**
     * Show blog posts
     */
    public function blog()
    {
        // For now, return a simple view with empty data
        // You can implement blog functionality later
        $posts = collect(); // Empty collection
        return view('blog', compact('posts'));
    }

    /**
     * Show a single blog post
     */
    public function blogShow($slug)
    {
        // For now, return a simple view
        // You can implement blog functionality later
        $post = (object) [
            'title' => 'Sample Blog Post',
            'content' => 'This is a placeholder for blog functionality.',
            'slug' => $slug,
            'created_at' => now()
        ];
        
        return view('blog-show', compact('post'));
    }

    /**
     * Show privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Show terms of service page
     */
    public function terms()
    {
        return view('terms');
    }
}

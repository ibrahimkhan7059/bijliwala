<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Recent products
        $recent_products = Product::latest()->take(5)->get();

        // Recent orders (when we implement orders)
        $recent_orders = collect(); // Order::latest()->take(5)->get();

        // Top selling products (placeholder for now)
        $top_products = Product::where('is_featured', true)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'recent_orders', 'top_products'));
    }
}

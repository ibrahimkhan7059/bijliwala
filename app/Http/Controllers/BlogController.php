<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs
     */
    public function index()
    {
        $blogs = Blog::published()
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        return view('blog', compact('blogs'));
    }

    /**
     * Display the specified blog and increment views
     */
    public function show(Blog $blog)
    {
        // Only show published blogs
        if ($blog->status !== 'published') {
            abort(404);
        }

        // Increment views
        $blog->incrementViews();

        return view('blog-show', compact('blog'));
    }
}

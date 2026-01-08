<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'created_desc');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'views_desc':
                $query->orderBy('views', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $blogs = $query->paginate($perPage)->appends($request->all());

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'status' => 'required|in:published,draft',
        ]);

        $data = $request->all();

        // Extract YouTube thumbnail if URL is valid
        $blog = new Blog($data);
        if ($blog->youtube_id) {
            $data['thumbnail'] = $blog->youtube_thumbnail;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
                        ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'status' => 'required|in:published,draft',
        ]);

        $data = $request->all();

        // Extract YouTube thumbnail if URL is valid
        $tempBlog = new Blog($data);
        if ($tempBlog->youtube_id) {
            $data['thumbnail'] = $tempBlog->youtube_thumbnail;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
                        ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
                        ->with('success', 'Blog post deleted successfully!');
    }
}

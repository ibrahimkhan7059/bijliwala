<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:published,draft',
        ]);

        $data = $request->all();

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $path = $file->store('blogs', 'public');
            $data['thumbnail'] = $path;
        } else {
            // Extract YouTube thumbnail if no cover photo uploaded
            $videoId = Blog::extractYoutubeVideoId($data['youtube_url']);
            if ($videoId) {
                $data['thumbnail'] = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            }
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
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:published,draft',
        ]);

        $data = $request->all();

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            // Delete old image if it exists and is not a YouTube URL
            if ($blog->thumbnail && !str_contains($blog->thumbnail, 'youtube')) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            
            $file = $request->file('cover_photo');
            $path = $file->store('blogs', 'public');
            $data['thumbnail'] = $path;
        } else {
            // Extract YouTube thumbnail if no cover photo uploaded and thumbnail not already set
            if (!isset($data['thumbnail']) || empty($data['thumbnail'])) {
                $videoId = Blog::extractYoutubeVideoId($data['youtube_url']);
                if ($videoId) {
                    $data['thumbnail'] = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                }
            }
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
        // Delete thumbnail if it's a custom upload (not YouTube URL)
        if ($blog->thumbnail && !str_contains($blog->thumbnail, 'youtube')) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')
                        ->with('success', 'Blog post deleted successfully!');
    }
}

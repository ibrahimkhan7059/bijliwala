<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'thumbnail',
        'status',
        'views',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    /**
     * Get YouTube video ID from URL
     */
    public function getYoutubeIdAttribute()
    {
        $url = $this->youtube_url;
        
        // Extract video ID from various YouTube URL formats
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getEmbedUrlAttribute()
    {
        $videoId = $this->youtube_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getYoutubeThumbnailAttribute()
    {
        $videoId = $this->youtube_id;
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }

    /**
     * Scope for published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'author_id', 'title', 'slug', 'excerpt',
        'content', 'cover_image', 'status', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function author()
    {
        return $this->belongsTo(TeamMember::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tags', 'post_id', 'tag_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderByDesc('published_at');
    }
}

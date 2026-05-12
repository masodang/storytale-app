<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'client', 'description',
        'content', 'cover_image', 'custom_metrics', 'custom_scope',
        'embed_code', 'project_year', 'is_featured', 'status', 'sort_order',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'custom_metrics' => 'array',
        'custom_scope'   => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

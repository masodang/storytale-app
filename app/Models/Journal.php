<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Journal extends Model {
    protected $fillable = ['title','slug','category','excerpt','cover_image','pdf_url','status','published_at','sort_order'];
    protected $casts = ['published_at' => 'datetime'];
    public function scopePublished($q) { return $q->where('status','published')->orderBy('sort_order'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Service extends Model {
    protected $fillable = ['name','slug','color','description','scope_items','sort_order','is_active'];
    protected $casts = ['scope_items' => 'array','is_active' => 'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true)->orderBy('sort_order'); }
}

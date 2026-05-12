<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model {
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null) {
        return Cache::remember("setting_{$key}", 300, function() use ($key, $default) {
            $row = static::where('key', $key)->first();
            return $row ? json_decode($row->value, true) : $default;
        });
    }

    public static function set(string $key, $value): void {
        static::updateOrCreate(['key' => $key], ['value' => json_encode($value)]);
        Cache::forget("setting_{$key}");
    }
}

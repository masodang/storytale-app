<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $isPdf = $request->file('file') && $request->file('file')->getClientOriginalExtension() === 'pdf';

        $request->validate([
            'file' => $isPdf
                ? 'required|file|mimes:pdf|max:51200'
                : 'required|file|mimes:jpg,jpeg,png,gif,webp,svg|max:7168',
        ]);

        $disk = 'webroot';
        $path = $request->file('file')->store($isPdf ? 'pdf' : 'projects', $disk);

        $fullUrl = Storage::disk($disk)->url($path);
        $url = parse_url($fullUrl, PHP_URL_PATH) . (parse_url($fullUrl, PHP_URL_QUERY) ? '?' . parse_url($fullUrl, PHP_URL_QUERY) : '');

        return response()->json(['url' => $url]);
    }

    public function destroyImage(ProjectImage $image)
    {
        $url = $image->image_url;

        // Try webroot disk
        if (str_contains($url, '/uploads/')) {
            $rel = substr($url, strpos($url, '/uploads/') + 9);
            Storage::disk('webroot')->delete('projects/' . basename($rel));
        }
        // Legacy: public disk (storage symlink)
        if (str_contains($url, '/storage/uploads/')) {
            $rel = 'uploads/' . substr($url, strpos($url, '/uploads/') + 9);
            Storage::disk('public')->delete($rel);
        }

        $image->delete();

        return response()->json(['ok' => true]);
    }
}

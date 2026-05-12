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
                : 'required|file|mimes:jpg,jpeg,png,gif,webp,svg|max:10240',
        ]);

        $path = $request->file('file')->store('uploads/projects', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    public function destroyImage(ProjectImage $image)
    {
        $url = $image->image_url;

        if (str_contains($url, '/storage/uploads/')) {
            $relativePath = 'uploads/' . substr($url, strpos($url, '/uploads/') + 9);
            Storage::disk('public')->delete($relativePath);
        }

        $image->delete();

        return response()->json(['ok' => true]);
    }
}

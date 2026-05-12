<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::with(['author', 'tags'])
            ->published()
            ->paginate($request->integer('per_page', 10));

        return response()->json($posts);
    }

    public function show(string $slug)
    {
        $post = BlogPost::with(['author', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($post);
    }

    public function team()
    {
        return response()->json(TeamMember::active()->get());
    }
}

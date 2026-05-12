<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('category')
            ->published();

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        return response()->json($query->get()->map(fn($p) => [
            'id'            => $p->id,
            'title'         => $p->title,
            'slug'          => $p->slug,
            'client'        => $p->client,
            'description'   => $p->description,
            'cover_image'   => $p->cover_image,
            'project_year'  => $p->project_year,
            'is_featured'   => $p->is_featured,
            'category_name' => $p->category?->name,
            'category_slug' => $p->category?->slug,
        ]));
    }

    public function show(string $slug)
    {
        $project = Project::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($project);
    }
}

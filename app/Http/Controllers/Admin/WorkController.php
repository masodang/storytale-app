<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('category')->orderBy('sort_order')->orderBy('id');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('client', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $projects   = $query->get();
        $categories = ProjectCategory::orderBy('name')->get();

        return view('admin.work.index', compact('projects', 'categories'));
    }

    public function create()
    {
        return view('admin.work.form', [
            'project'    => null,
            'categories' => ProjectCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data         = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug']);

        $project = Project::create($data);

        $this->syncImages($project, $request);

        return redirect()->route('admin.work.index')->with('success', 'Project created.');
    }

    public function edit(Project $work)
    {
        $work->load('images');

        return view('admin.work.form', [
            'project'    => $work,
            'categories' => ProjectCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $work)
    {
        $data = $this->validated($request, $work->id);

        if ($data['slug'] !== $work->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], $work->id);
        }

        $work->update($data);

        $this->syncImages($work, $request);

        return redirect()->route('admin.work.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $work)
    {
        $work->images()->delete();
        $work->delete();

        return redirect()->route('admin.work.index')->with('success', 'Project deleted.');
    }

    public function toggleFeatured(Project $work)
    {
        $work->update(['is_featured' => !$work->is_featured]);
        return response()->json(['is_featured' => $work->is_featured]);
    }

    public function toggleStatus(Project $work)
    {
        $work->update(['status' => $work->status === 'published' ? 'draft' : 'published']);
        return response()->json(['status' => $work->status]);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|max:255',
            'client'       => 'required|string|max:255',
            'category_id'  => 'required|exists:project_categories,id',
            'description'  => 'required|string',
            'content'      => 'nullable|string',
            'cover_image'  => 'nullable|string|max:500',
            'embed_items'  => 'nullable|array',
            'embed_items.*'=> 'nullable|string',
            'project_year' => 'required|integer|min:2000|max:2100',
            'is_featured'  => 'boolean',
            'status'       => 'required|in:draft,published',
            'sort_order'   => 'integer|min:0',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order']  = $data['sort_order'] ?? 0;

        // Convert URLs to iframe embeds
        $embedItems = array_filter((array) $request->input('embed_items', []), fn($v) => trim($v) !== '');
        $iframes = array_map(fn($url) => $this->urlToIframe(trim($url)), $embedItems);
        $data['embed_code'] = count($iframes) ? implode("\n", $iframes) : null;
        unset($data['embed_items'], $data['embed_items.*']);

        // Custom metrics
        $metrics = [];
        foreach ((array) $request->input('metrics_val', []) as $i => $val) {
            $label = $request->input("metrics_label.{$i}");
            if (trim($val) !== '' && trim($label ?? '') !== '') {
                $metrics[] = ['val' => trim($val), 'label' => trim($label)];
            }
        }
        $data['custom_metrics'] = count($metrics) ? $metrics : null;

        // Custom scope tags
        $scopeRaw = $request->input('custom_scope_json', '');
        $scope    = json_decode($scopeRaw, true);
        $data['custom_scope'] = (is_array($scope) && count($scope)) ? array_values(array_filter($scope)) : null;

        return $data;
    }

    private function syncImages(Project $project, Request $request): void
    {
        // Delete images the user removed
        $deleteIds = array_filter(explode(',', $request->input('delete_image_ids', '')));
        if ($deleteIds) {
            ProjectImage::whereIn('id', $deleteIds)->where('project_id', $project->id)->delete();
        }

        // Add newly uploaded image URLs
        $newUrls = json_decode($request->input('new_image_urls', '[]'), true) ?: [];
        foreach ($newUrls as $i => $url) {
            ProjectImage::create([
                'project_id' => $project->id,
                'image_url'  => $url,
                'alt_text'   => $project->title,
                'sort_order' => $project->images()->max('sort_order') + $i + 1,
            ]);
        }
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug);
        $slug = $base;
        $n    = 1;

        while (
            Project::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }

    private function urlToIframe(string $input): string
    {
        if (str_contains($input, '<iframe')) return $input;

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $input, $m)) {
            $attrs = 'width="100%" height="480" frameborder="0" allowfullscreen style="border:0"';
            return "<iframe src=\"https://www.youtube.com/embed/{$m[1]}\" {$attrs} allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"></iframe>";
        }
        if (preg_match('/vimeo\.com\/(\d+)/', $input, $m)) {
            $attrs = 'width="100%" height="480" frameborder="0" allowfullscreen style="border:0"';
            return "<iframe src=\"https://player.vimeo.com/video/{$m[1]}\" {$attrs} allow=\"autoplay; fullscreen; picture-in-picture\"></iframe>";
        }
        if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $input, $m)) {
            $attrs = 'width="100%" height="600" frameborder="0" style="border:0"';
            return "<iframe src=\"https://drive.google.com/file/d/{$m[1]}/preview\" {$attrs}></iframe>";
        }
        if (preg_match('/docs\.google\.com\/presentation\/d\/([a-zA-Z0-9_-]+)/', $input, $m)) {
            $attrs = 'width="100%" height="650" frameborder="0" allowfullscreen style="border:0"';
            return "<iframe src=\"https://docs.google.com/presentation/d/{$m[1]}/embed\" {$attrs}></iframe>";
        }
        if (str_contains($input, 'figma.com')) {
            $attrs = 'width="100%" height="700" frameborder="0" style="border:0"';
            return "<iframe src=\"https://www.figma.com/embed?embed_host=share&url=" . urlencode($input) . "\" {$attrs}></iframe>";
        }
        $attrs = 'width="100%" height="480" frameborder="0" allowfullscreen style="border:0"';
        return "<iframe src=\"{$input}\" {$attrs}></iframe>";
    }
}

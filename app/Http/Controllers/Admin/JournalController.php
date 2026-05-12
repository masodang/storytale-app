<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JournalController extends Controller {
    public function index() {
        return view('admin.journal.index', ['journals' => Journal::orderBy('sort_order')->orderByDesc('published_at')->get()]);
    }
    public function create() { return view('admin.journal.form', ['journal' => null]); }
    public function store(Request $request) {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(Str::slug($data['title']));
        Journal::create($data);
        return redirect()->route('admin.journal.index')->with('success','Journal created.');
    }
    public function edit(Journal $journal) { return view('admin.journal.form', compact('journal')); }
    public function update(Request $request, Journal $journal) {
        $data = $this->validated($request, $journal->id);
        $journal->update($data);
        return redirect()->route('admin.journal.index')->with('success','Journal updated.');
    }
    public function destroy(Journal $journal) {
        $journal->delete();
        return redirect()->route('admin.journal.index')->with('success','Journal deleted.');
    }
    private function validated(Request $request, ?int $ignoreId = null): array {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:case-study,learning,insight,whitepaper,report',
            'excerpt'      => 'nullable|string',
            'cover_image'  => 'nullable|string|max:500',
            'pdf_url'      => 'nullable|string|max:500',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'sort_order'   => 'integer|min:0',
        ]);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        return $data;
    }
    private function uniqueSlug(string $base, ?int $ignoreId = null): string {
        $slug = $base; $n = 1;
        while (Journal::where('slug',$slug)->when($ignoreId, fn($q)=>$q->where('id','!=',$ignoreId))->exists()) {
            $slug = $base.'-'.$n++;
        }
        return $slug;
    }
}

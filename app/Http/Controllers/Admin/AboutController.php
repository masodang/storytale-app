<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class AboutController extends Controller {
    public function index() {
        return view('admin.about.index', ['members' => TeamMember::orderBy('sort_order')->get()]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'bio'        => 'nullable|string',
            'photo_url'  => 'nullable|string|max:500',
            'email'      => 'nullable|email',
            'instagram'  => 'nullable|string|max:100',
            'linkedin'   => 'nullable|string|max:200',
            'sort_order' => 'integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        TeamMember::create($data);
        return redirect()->route('admin.about.index')->with('success','Team member added.');
    }
    public function update(Request $request, TeamMember $about) {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'bio'        => 'nullable|string',
            'photo_url'  => 'nullable|string|max:500',
            'email'      => 'nullable|email',
            'instagram'  => 'nullable|string|max:100',
            'linkedin'   => 'nullable|string|max:200',
            'sort_order' => 'integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $about->update($data);
        return redirect()->route('admin.about.index')->with('success','Team member updated.');
    }
    public function destroy(TeamMember $about) {
        $about->delete();
        return redirect()->route('admin.about.index')->with('success','Member removed.');
    }
}

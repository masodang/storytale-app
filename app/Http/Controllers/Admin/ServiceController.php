<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller {
    public function index() { return view('admin.service.index', ['services' => Service::orderBy('sort_order')->get()]); }
    public function edit(Service $service) { return view('admin.service.form', compact('service')); }
    public function update(Request $request, Service $service) {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'color'       => 'required|string|max:20',
            'description' => 'nullable|string',
            'sort_order'  => 'integer|min:0',
        ]);
        $scopeRaw = $request->input('scope_json','');
        $scope = json_decode($scopeRaw, true);
        $data['scope_items'] = (is_array($scope) && count($scope)) ? $scope : null;
        $data['is_active'] = $request->boolean('is_active', true);
        $service->update($data);
        return redirect()->route('admin.service.index')->with('success','Service updated.');
    }
    public function toggleActive(Service $service) {
        $service->update(['is_active' => !$service->is_active]);
        return response()->json(['is_active' => $service->is_active]);
    }
}

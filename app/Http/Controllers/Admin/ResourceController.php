<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResourceRequest;
use App\Models\Resource;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'pageSettings' => SiteSetting::query()->where('group', 'resources_page')->orderBy('key')->get(),
            'resources' => Resource::query()->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.resources.create');
    }

    public function store(ResourceRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('file');
        $data['file_path'] = $request->file('file')->store('resources', 'public');

        Resource::query()->create($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource uploaded.');
    }

    public function edit(Resource $resource): View
    {
        return view('admin.resources.edit', ['resource' => $resource]);
    }

    public function update(ResourceRequest $request, Resource $resource): RedirectResponse
    {
        $data = $request->safe()->except('file');

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($resource->file_path);
            $data['file_path'] = $request->file('file')->store('resources', 'public');
        }

        $resource->update($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource updated.');
    }

    public function destroy(Resource $resource): RedirectResponse
    {
        Storage::disk('public')->delete($resource->file_path);
        $resource->delete();

        return redirect()->route('admin.resources.index')->with('success', 'Resource removed.');
    }
}

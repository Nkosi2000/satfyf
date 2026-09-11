<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('pages.resources', [
            'resources' => Resource::query()->published()->latest()->get()->groupBy('category'),
        ]);
    }

    public function download(Resource $resource): RedirectResponse
    {
        abort_unless($resource->published, 404);

        return redirect(Storage::disk('public')->url($resource->file_path));
    }
}

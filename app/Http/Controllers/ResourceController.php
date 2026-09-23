<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('pages.resources', [
            'content' => SiteSetting::group('resources_page'),
            'resources' => Resource::publishedLatest()->groupBy('category'),
        ]);
    }

    public function download(Resource $resource): RedirectResponse
    {
        abort_unless($resource->published, 404);

        return redirect(storage_url($resource->file_path));
    }
}

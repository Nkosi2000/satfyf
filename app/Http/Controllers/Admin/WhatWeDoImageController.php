<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhatWeDoImageRequest;
use App\Models\WhatWeDoImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WhatWeDoImageController extends Controller
{
    public function index(): View
    {
        return view('admin.what-we-do-images.index', [
            'images' => WhatWeDoImage::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.what-we-do-images.create');
    }

    public function store(WhatWeDoImageRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['image_path'] = $request->file('image')->store('what-we-do', 'public');

        WhatWeDoImage::query()->create($data);

        return redirect()->route('admin.what-we-do-images.index')->with('success', 'Image added.');
    }

    public function edit(WhatWeDoImage $whatWeDoImage): View
    {
        return view('admin.what-we-do-images.edit', ['image' => $whatWeDoImage]);
    }

    public function update(WhatWeDoImageRequest $request, WhatWeDoImage $whatWeDoImage): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            if (! str_starts_with($whatWeDoImage->image_path, 'http')) {
                Storage::disk('public')->delete($whatWeDoImage->image_path);
            }

            $data['image_path'] = $request->file('image')->store('what-we-do', 'public');
        }

        $whatWeDoImage->update($data);

        return redirect()->route('admin.what-we-do-images.index')->with('success', 'Image updated.');
    }

    public function destroy(WhatWeDoImage $whatWeDoImage): RedirectResponse
    {
        if (! str_starts_with($whatWeDoImage->image_path, 'http')) {
            Storage::disk('public')->delete($whatWeDoImage->image_path);
        }

        $whatWeDoImage->delete();

        return redirect()->route('admin.what-we-do-images.index')->with('success', 'Image removed.');
    }
}

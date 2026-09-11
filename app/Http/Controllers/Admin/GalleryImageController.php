<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryImageRequest;
use App\Models\GalleryImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryImageController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', [
            'images' => GalleryImage::query()->ordered()->paginate(24),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(GalleryImageRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['image_path'] = $request->file('image')->store('gallery', 'public');

        GalleryImage::query()->create($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Image added.');
    }

    public function edit(GalleryImage $galleryImage): View
    {
        return view('admin.gallery.edit', ['image' => $galleryImage]);
    }

    public function update(GalleryImageRequest $request, GalleryImage $galleryImage): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            if (! str_starts_with($galleryImage->image_path, 'http')) {
                Storage::disk('public')->delete($galleryImage->image_path);
            }

            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $galleryImage->update($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Image updated.');
    }

    public function destroy(GalleryImage $galleryImage): RedirectResponse
    {
        if (! str_starts_with($galleryImage->image_path, 'http')) {
            Storage::disk('public')->delete($galleryImage->image_path);
        }

        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index')->with('success', 'Image removed.');
    }
}

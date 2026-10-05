<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryHeroImageRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

/**
 * The Gallery page's hero image, uploaded from the admin Gallery screen.
 * Stored as a file path in the `gallery_page_hero_image` site setting —
 * its own `gallery_page_media` group, so the text-only "Page header"
 * panel never renders it as a text field. With no upload, the public page
 * falls back to the first gallery image.
 */
class GalleryHeroImageController extends Controller
{
    public const SETTING_KEY = 'gallery_page_hero_image';

    public function update(GalleryHeroImageRequest $request): RedirectResponse
    {
        $this->deleteStoredImage();

        SiteSetting::query()->updateOrCreate(
            ['key' => self::SETTING_KEY],
            [
                'group' => 'gallery_page_media',
                'value' => json_encode(['en' => $request->file('image')->store('gallery/hero', 'public')]),
            ],
        );

        return redirect()->route('admin.gallery-images.index')->with('success', 'Page hero image updated.');
    }

    public function destroy(): RedirectResponse
    {
        $this->deleteStoredImage();

        SiteSetting::query()->where('key', self::SETTING_KEY)->first()?->delete();

        return redirect()->route('admin.gallery-images.index')->with('success', 'Page hero image removed.');
    }

    private function deleteStoredImage(): void
    {
        $path = SiteSetting::get(self::SETTING_KEY);

        if ($path && ! str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }
}

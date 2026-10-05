<?php

use App\Http\Controllers\Admin\GalleryHeroImageController;
use App\Models\GalleryImage;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('blocks guests from changing the gallery hero image', function () {
    $this->put(route('admin.gallery-hero-image.update'))->assertRedirect(route('admin.login'));
    $this->delete(route('admin.gallery-hero-image.destroy'))->assertRedirect(route('admin.login'));
});

it('uploads a gallery hero image and shows it on the public gallery page', function () {
    Storage::fake('public');
    GalleryImage::factory()->create(['image_path' => 'gallery/first.jpg']);

    $this->actingAs($this->admin)
        ->put(route('admin.gallery-hero-image.update'), ['image' => UploadedFile::fake()->image('hero.jpg')])
        ->assertRedirect(route('admin.gallery-images.index'));

    $path = SiteSetting::get(GalleryHeroImageController::SETTING_KEY);

    expect($path)->toStartWith('gallery/hero/');
    Storage::disk('public')->assertExists($path);

    $this->get(route('gallery'))
        ->assertOk()
        ->assertSee('data-gallery-hero-image', false)
        ->assertSee($path, false);
});

it('deletes the previous file when the hero image is replaced', function () {
    Storage::fake('public');

    $this->actingAs($this->admin)->put(route('admin.gallery-hero-image.update'), ['image' => UploadedFile::fake()->image('old.jpg')]);
    $oldPath = SiteSetting::get(GalleryHeroImageController::SETTING_KEY);

    $this->actingAs($this->admin)->put(route('admin.gallery-hero-image.update'), ['image' => UploadedFile::fake()->image('new.jpg')]);
    $newPath = SiteSetting::get(GalleryHeroImageController::SETTING_KEY);

    expect($newPath)->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($newPath);
});

it('removes the hero image and falls back to the first gallery image', function () {
    Storage::fake('public');
    GalleryImage::factory()->create(['image_path' => 'gallery/first.jpg', 'order' => 0]);

    $this->actingAs($this->admin)->put(route('admin.gallery-hero-image.update'), ['image' => UploadedFile::fake()->image('hero.jpg')]);
    $path = SiteSetting::get(GalleryHeroImageController::SETTING_KEY);

    $this->actingAs($this->admin)
        ->delete(route('admin.gallery-hero-image.destroy'))
        ->assertRedirect(route('admin.gallery-images.index'));

    expect(SiteSetting::get(GalleryHeroImageController::SETTING_KEY))->toBeNull();
    Storage::disk('public')->assertMissing($path);

    $this->get(route('gallery'))
        ->assertOk()
        ->assertDontSee('data-gallery-hero-image', false)
        ->assertSee('gallery/first.jpg', false);
});

it('requires an image file', function () {
    $this->actingAs($this->admin)
        ->put(route('admin.gallery-hero-image.update'), [])
        ->assertSessionHasErrors('image');

    expect(SiteSetting::get(GalleryHeroImageController::SETTING_KEY))->toBeNull();
});

it('keeps the hero image out of the text-only page header panel', function () {
    Storage::fake('public');
    $this->actingAs($this->admin)->put(route('admin.gallery-hero-image.update'), ['image' => UploadedFile::fake()->image('hero.jpg')]);

    $this->actingAs($this->admin)
        ->get(route('admin.gallery-images.index'))
        ->assertOk()
        ->assertSee('data-gallery-hero-panel', false)
        ->assertDontSee('settings[gallery_page_hero_image]', false);
});

<?php

use App\Models\User;
use App\Models\WhatWeDoImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the what we do slideshow', function () {
    $this->get(route('admin.what-we-do-images.index'))->assertRedirect(route('admin.login'));
});

it('lists slideshow images', function () {
    WhatWeDoImage::factory()->create(['caption' => 'Youth march in Pretoria']);

    $this->actingAs($this->admin)
        ->get(route('admin.what-we-do-images.index'))
        ->assertOk()
        ->assertSee('Youth march in Pretoria');
});

it('uploads a slideshow image', function () {
    Storage::fake('public');

    $this->actingAs($this->admin)
        ->post(route('admin.what-we-do-images.store'), [
            'caption' => 'Think session',
            'order' => 2,
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ])
        ->assertRedirect(route('admin.what-we-do-images.index'));

    $image = WhatWeDoImage::query()->sole();

    expect($image->caption)->toBe('Think session')
        ->and($image->order)->toBe(2);
    Storage::disk('public')->assertExists($image->image_path);
});

it('requires an image when adding one', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.what-we-do-images.store'), ['caption' => 'No file'])
        ->assertSessionHasErrors('image');

    expect(WhatWeDoImage::query()->count())->toBe(0);
});

it('replaces the stored file when a new image is uploaded', function () {
    Storage::fake('public');
    $oldPath = UploadedFile::fake()->image('old.jpg')->store('what-we-do', 'public');
    $image = WhatWeDoImage::factory()->create(['image_path' => $oldPath]);

    $this->actingAs($this->admin)
        ->put(route('admin.what-we-do-images.update', $image), [
            'caption' => 'Updated',
            'order' => 0,
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])
        ->assertRedirect(route('admin.what-we-do-images.index'));

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($image->refresh()->image_path);
});

it('deletes an image and its stored file', function () {
    Storage::fake('public');
    $path = UploadedFile::fake()->image('photo.jpg')->store('what-we-do', 'public');
    $image = WhatWeDoImage::factory()->create(['image_path' => $path]);

    $this->actingAs($this->admin)
        ->delete(route('admin.what-we-do-images.destroy', $image))
        ->assertRedirect(route('admin.what-we-do-images.index'));

    expect(WhatWeDoImage::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

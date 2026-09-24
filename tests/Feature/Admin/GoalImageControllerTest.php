<?php

use App\Models\GoalImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the goals slideshow', function () {
    $this->get(route('admin.goal-images.index'))->assertRedirect(route('admin.login'));
});

it('lists slideshow images', function () {
    GoalImage::factory()->create(['caption' => 'Youth march in Pretoria']);

    $this->actingAs($this->admin)
        ->get(route('admin.goal-images.index'))
        ->assertOk()
        ->assertSee('Youth march in Pretoria');
});

it('uploads a slideshow image', function () {
    Storage::fake('public');

    $this->actingAs($this->admin)
        ->post(route('admin.goal-images.store'), [
            'caption' => 'Think session',
            'order' => 2,
            'image' => UploadedFile::fake()->image('goal.jpg'),
        ])
        ->assertRedirect(route('admin.goal-images.index'));

    $image = GoalImage::query()->sole();

    expect($image->caption)->toBe('Think session')
        ->and($image->order)->toBe(2);
    Storage::disk('public')->assertExists($image->image_path);
});

it('requires an image when adding one', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.goal-images.store'), ['caption' => 'No file'])
        ->assertSessionHasErrors('image');

    expect(GoalImage::query()->count())->toBe(0);
});

it('replaces the stored file when a new image is uploaded', function () {
    Storage::fake('public');
    $oldPath = UploadedFile::fake()->image('old.jpg')->store('goals', 'public');
    $image = GoalImage::factory()->create(['image_path' => $oldPath]);

    $this->actingAs($this->admin)
        ->put(route('admin.goal-images.update', $image), [
            'caption' => 'Updated',
            'order' => 0,
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])
        ->assertRedirect(route('admin.goal-images.index'));

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($image->refresh()->image_path);
});

it('deletes an image and its stored file', function () {
    Storage::fake('public');
    $path = UploadedFile::fake()->image('goal.jpg')->store('goals', 'public');
    $image = GoalImage::factory()->create(['image_path' => $path]);

    $this->actingAs($this->admin)
        ->delete(route('admin.goal-images.destroy', $image))
        ->assertRedirect(route('admin.goal-images.index'));

    expect(GoalImage::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

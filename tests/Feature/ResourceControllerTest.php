<?php

use App\Models\Resource;
use Illuminate\Support\Facades\Storage;

it('lists published resources grouped by category', function () {
    Resource::factory()->create(['title' => 'Youth Fact Sheet', 'category' => 'Fact Sheet']);

    $this->get('/resources')
        ->assertOk()
        ->assertSee('Youth Fact Sheet')
        ->assertSee('Fact Sheet');
});

it('does not list unpublished resources', function () {
    Resource::factory()->create(['title' => 'Internal Draft', 'published' => false]);

    $this->get('/resources')->assertDontSee('Internal Draft');
});

it('redirects to the file for a published resource download', function () {
    Storage::fake('public');
    Storage::disk('public')->put('resources/handout.pdf', 'contents');

    $resource = Resource::factory()->create(['file_path' => 'resources/handout.pdf']);

    $this->get(route('resources.download', $resource))
        ->assertRedirect(Storage::disk('public')->url('resources/handout.pdf'));
});

it('returns 404 when downloading an unpublished resource', function () {
    $resource = Resource::factory()->create(['published' => false]);

    $this->get(route('resources.download', $resource))->assertNotFound();
});

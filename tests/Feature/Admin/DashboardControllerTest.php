<?php

use App\Console\Commands\WarmStorageUrls;
use App\Models\GoalImage;
use App\Models\User;
use App\Models\WhatWeDoImage;
use Illuminate\Support\Facades\Cache;

it('warns on the dashboard when the storage-url warm heartbeat is stale', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee("hasn't refreshed recently", false);
});

it('does not warn once the storage-url warm command has run recently', function () {
    $admin = User::factory()->admin()->create();
    Cache::forever('scheduler:warm-storage-urls:last-success', now()->toIso8601String());

    expect(WarmStorageUrls::isStale())->toBeFalse();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertDontSee("hasn't refreshed recently", false);
});

it('renders the collapsible sidebar and breadcrumb trail', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('data-admin-sidebar', false)
        ->assertSee('data-sidebar-toggle', false)
        ->assertSee('aria-label="Breadcrumb"', false);
});

it('pins the sidebar to the viewport with its own scrolling nav', function () {
    $admin = User::factory()->admin()->create();

    $html = $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->getContent();

    expect($html)
        ->toMatch('/<aside data-admin-sidebar class="[^"]*\blg:sticky lg:top-0\b[^"]*\blg:h-screen\b/')
        ->toMatch('/<nav data-admin-sidebar-nav class="[^"]*\boverflow-y-auto\b/');
});

it('renders every nav section closed on the dashboard', function () {
    $admin = User::factory()->admin()->create();

    $html = $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('aria-controls="admin-nav-group-pages"', false)
        ->getContent();

    expect($html)
        ->toMatch('/id="admin-nav-group-pages"\s+data-nav-group-panel\s+data-open="false"/')
        ->not->toMatch('/data-nav-group-panel\s+data-open="true"/');
});

it('opens only the nav section holding the current page', function () {
    $admin = User::factory()->admin()->create();

    $html = $this->actingAs($admin)
        ->get(route('admin.articles.index'))
        ->assertOk()
        ->getContent();

    expect($html)
        ->toMatch('/id="admin-nav-group-content"\s+data-nav-group-panel\s+data-open="true"/')
        ->toMatch('/id="admin-nav-group-pages"\s+data-nav-group-panel\s+data-open="false"/');
});

it('counts both page slideshows on the dashboard', function () {
    $admin = User::factory()->admin()->create();
    GoalImage::factory()->count(2)->create();
    WhatWeDoImage::factory()->count(3)->create();

    $html = $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->getContent();

    expect($html)
        ->toMatch('/>2<\/p>\s*<p[^>]*>Goals slideshow images</')
        ->toMatch('/>3<\/p>\s*<p[^>]*>What We Do slideshow images</');
});

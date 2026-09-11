<?php

use App\Models\EventItem;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the event list', function () {
    $this->get(route('admin.events.index'))->assertRedirect(route('admin.login'));
});

describe('index', function () {
    it('lists events', function () {
        EventItem::factory()->create(['title' => 'Season Launch']);

        $this->actingAs($this->admin)
            ->get(route('admin.events.index'))
            ->assertOk()
            ->assertSee('Season Launch');
    });
});

describe('store', function () {
    it('creates an event with an uploaded cover image', function () {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            'title' => ['en' => 'New Event'],
            'slug' => 'new-event',
            'description' => ['en' => 'Details about the event.'],
            'location' => ['en' => 'Centurion'],
            'starts_at' => now()->addWeek()->format('Y-m-d\TH:i'),
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event = EventItem::query()->where('slug', 'new-event')->firstOrFail();
        expect($event->title)->toBe('New Event');
        Storage::disk('public')->assertExists($event->cover_image_path);
    });

    it('rejects a submission with an empty payload', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), []);

        $response->assertSessionHasErrors(['title.en', 'slug', 'description.en', 'starts_at']);
        expect(EventItem::query()->count())->toBe(0);
    });
});

describe('edit', function () {
    // Regression test: the edit page must render the actual bound event —
    // a controller parameter name that doesn't match the route's {event}
    // placeholder makes Laravel silently inject an empty model instead.
    it('renders the edit form with the bound event\'s own data', function () {
        $event = EventItem::factory()->create(['title' => 'Bound Event Title']);

        $this->actingAs($this->admin)
            ->get(route('admin.events.edit', $event))
            ->assertOk()
            ->assertSee('Bound Event Title')
            ->assertSee(route('admin.events.update', $event), false);
    });
});

describe('update', function () {
    it('updates the same event record rather than creating a new one', function () {
        $event = EventItem::factory()->create(['title' => 'Original Title']);

        $response = $this->actingAs($this->admin)->put(route('admin.events.update', $event), [
            'title' => ['en' => 'Updated Title'],
            'slug' => $event->slug,
            'description' => ['en' => $event->description],
            'starts_at' => $event->starts_at->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('admin.events.index'));

        expect(EventItem::query()->count())->toBe(1);
        expect($event->refresh()->title)->toBe('Updated Title');
    });

    it('replaces the cover image', function () {
        Storage::fake('public');
        $event = EventItem::factory()->create(['cover_image_path' => 'events/old.jpg']);
        Storage::disk('public')->put('events/old.jpg', 'old contents');

        $response = $this->actingAs($this->admin)->put(route('admin.events.update', $event), [
            'title' => ['en' => $event->title],
            'slug' => $event->slug,
            'description' => ['en' => $event->description],
            'starts_at' => $event->starts_at->format('Y-m-d\TH:i'),
            'cover_image' => UploadedFile::fake()->image('new-cover.jpg'),
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event->refresh();
        Storage::disk('public')->assertMissing('events/old.jpg');
        Storage::disk('public')->assertExists($event->cover_image_path);
    });
});

it('deletes the same event that was targeted', function () {
    Storage::fake('public');
    $event = EventItem::factory()->create(['cover_image_path' => 'events/to-delete.jpg']);
    Storage::disk('public')->put('events/to-delete.jpg', 'contents');

    $response = $this->actingAs($this->admin)->delete(route('admin.events.destroy', $event));

    $response->assertRedirect(route('admin.events.index'));
    expect(EventItem::query()->find($event->id))->toBeNull();
    Storage::disk('public')->assertMissing('events/to-delete.jpg');
});

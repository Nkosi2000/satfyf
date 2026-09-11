<?php

use App\Models\EventItem;

describe('index', function () {
    it('lists upcoming and past events separately', function () {
        EventItem::factory()->create(['title' => 'Future Gathering', 'starts_at' => now()->addWeek()]);
        EventItem::factory()->create(['title' => 'Past Gathering', 'starts_at' => now()->subWeek()]);

        $this->get('/events')
            ->assertOk()
            ->assertSee('Future Gathering')
            ->assertSee('Past Gathering');
    });

    it('does not list unpublished events', function () {
        EventItem::factory()->create(['title' => 'Hidden Event', 'published' => false]);

        $this->get('/events')->assertDontSee('Hidden Event');
    });
});

describe('show', function () {
    it('renders a published event', function () {
        $event = EventItem::factory()->create(['title' => 'A Public Event']);

        $this->get(route('events.show', $event))
            ->assertOk()
            ->assertSee('A Public Event');
    });

    it('returns 404 for an unpublished event', function () {
        $event = EventItem::factory()->create(['published' => false]);

        $this->get(route('events.show', $event))->assertNotFound();
    });
});

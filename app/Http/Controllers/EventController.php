<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use App\Models\SiteSetting;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('pages.events.index', [
            'content' => SiteSetting::group('events_page'),
            'upcoming' => EventItem::cachedUpcoming(),
            'past' => EventItem::query()->published()->past()->paginate(9, pageName: 'past_page'),
        ]);
    }

    public function show(EventItem $event): View
    {
        abort_unless($event->published, 404);

        return view('pages.events.show', [
            'event' => $event,
        ]);
    }
}

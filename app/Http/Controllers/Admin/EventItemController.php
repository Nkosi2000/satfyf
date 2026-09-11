<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventItemRequest;
use App\Models\EventItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventItemController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => EventItem::query()->latest('starts_at')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(EventItemRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('events', 'public');
        }

        EventItem::query()->create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event saved.');
    }

    public function edit(EventItem $eventItem): View
    {
        return view('admin.events.edit', ['event' => $eventItem]);
    }

    public function update(EventItemRequest $request, EventItem $eventItem): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');

        if ($request->hasFile('cover_image')) {
            if ($eventItem->cover_image_path) {
                Storage::disk('public')->delete($eventItem->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('events', 'public');
        }

        $eventItem->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(EventItem $eventItem): RedirectResponse
    {
        if ($eventItem->cover_image_path) {
            Storage::disk('public')->delete($eventItem->cover_image_path);
        }

        $eventItem->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event removed.');
    }
}

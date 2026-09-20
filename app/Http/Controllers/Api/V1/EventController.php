<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventItemResource;
use App\Models\EventItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = EventItem::query()->published();

        if ($request->boolean('upcoming')) {
            $query->upcoming();
        } else {
            $query->orderBy('starts_at');
        }

        return EventItemResource::collection($query->paginate(12));
    }

    public function show(EventItem $event): EventItemResource
    {
        abort_unless($event->published, 404);

        return new EventItemResource($event);
    }
}

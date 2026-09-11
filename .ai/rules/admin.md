---
paths:
  - 'app/Http/{Controllers,Requests}/Admin/**'
---

# Admin

## Route-bound parameter names must match the resource's derived name, not the model class
`Route::resource('events', EventItemController::class)` derives the route parameter `{event}` from the resource name ('events' → singular 'event'), not from the model class name. A controller method typed `EventItem $eventItem` silently fails to bind — Laravel's ImplicitRouteBinding only matches by exact name or Str::snake() fallback ('event_item' ≠ 'event'), so it falls through to the container instantiating a blank, unsaved model instead of throwing. Same trap applies inside FormRequest rules: `$this->route('event_item')` returns null, so `Rule::unique(...)->ignore(...)` silently ignores nothing.

This bit EventItemController + EventItemRequest for real (both fixed to use `$event`/`$this->route('event')`). Before typing a bound parameter on any Admin\*Controller or Admin\*Request method, run `php artisan route:list --path=admin` and match the exact `{placeholder}` name — don't infer it from the Eloquent model's class name.

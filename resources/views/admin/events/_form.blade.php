@php($event = $event ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="title" label="Title" :value="$event?->title" />
    <x-admin.field name="slug" label="Slug" :value="$event?->slug" hint="Used in the event URL." />
</div>

<x-admin.field name="description" label="Description" type="textarea" :value="$event?->description" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-3">
    <x-admin.field name="location" label="Location" :value="$event?->location" />
    <x-admin.field name="starts_at" label="Starts at" type="datetime-local" :value="$event?->starts_at?->format('Y-m-d\TH:i')" />
    <x-admin.field name="ends_at" label="Ends at" type="datetime-local" :value="$event?->ends_at?->format('Y-m-d\TH:i')" />
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-3">
    <x-admin.field name="cover_image" label="Cover image" type="file" :value="$event?->cover_image_path" />
    <x-admin.field name="is_featured" label="Featured" type="checkbox" :value="$event?->is_featured ?? false" />
    <x-admin.field name="published" label="Published" type="checkbox" :value="$event?->published ?? true" />
</div>

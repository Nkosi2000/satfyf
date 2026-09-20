@php($testimonial = $testimonial ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="name" label="Name" :value="$testimonial?->name" />
    <x-admin.field name="role" label="Role" :value="$testimonial?->role" hint="Optional — e.g. Parent, Youth Ambassador." />
</div>

<x-admin.translatable-field name="quote" label="Quote" type="textarea" :translations="$testimonial?->translations('quote') ?? []" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="photo" label="Photo" type="file" :value="$testimonial?->photo_path" />
    <x-admin.field name="order" label="Order" type="number" :value="$testimonial?->order ?? 0" />
</div>

<x-admin.field name="published" label="Published" type="checkbox" :value="$testimonial?->published ?? true" class="mt-5" />

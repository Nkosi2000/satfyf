@php($teamMember = $teamMember ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="name" label="Name" :value="$teamMember?->name" />
    <x-admin.translatable-field name="role" label="Role" :translations="$teamMember?->translations('role') ?? []" />
</div>

<x-admin.translatable-field name="bio" label="Bio" type="textarea" :translations="$teamMember?->translations('bio') ?? []" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="photo" label="Photo" type="file" :value="$teamMember?->photo_path" />
    <x-admin.field name="order" label="Order" type="number" :value="$teamMember?->order ?? 0" />
</div>

<x-admin.field name="published" label="Published" type="checkbox" :value="$teamMember?->published ?? true" class="mt-5" />

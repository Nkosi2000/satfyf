@php($program = $program ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="title" label="Title" :value="$program?->title" />
    <x-admin.field
        name="category"
        label="Category"
        type="select"
        :value="$program?->category?->value"
        :options="collect(\App\Enums\ProgramCategory::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])"
    />
</div>

<x-admin.field name="description" label="Description" type="textarea" :value="$program?->description" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="order" label="Order" type="number" :value="$program?->order ?? 0" />
    <x-admin.field name="published" label="Published" type="checkbox" :value="$program?->published ?? true" />
</div>

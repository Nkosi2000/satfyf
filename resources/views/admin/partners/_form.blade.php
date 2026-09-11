@php($partner = $partner ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="name" label="Name" :value="$partner?->name" />
    <x-admin.field name="url" label="Website URL" type="url" :value="$partner?->url" />
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="logo" label="Logo" type="file" :value="$partner?->logo_path" />
    <x-admin.field
        name="type"
        label="Type"
        type="select"
        :value="$partner?->type?->value"
        :options="collect(\App\Enums\PartnerType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])"
    />
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="order" label="Order" type="number" :value="$partner?->order ?? 0" />
    <x-admin.field name="published" label="Published" type="checkbox" :value="$partner?->published ?? true" />
</div>

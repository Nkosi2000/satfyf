@php($partner = $partner ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="name" label="Name" :value="$partner?->name" />
    <x-admin.field
        name="type"
        label="Type (section on the Partners page)"
        type="select"
        :value="$partner?->type?->value"
        :options="collect(\App\Enums\PartnerType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])"
        hint="Decides which section of the public Partners page this partner is listed under."
    />
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="url" label="Website URL" type="url" :value="$partner?->url" hint="Opens from the 'Visit' button on the back of the card. Include https://." />
    <x-admin.field name="logo" label="Logo" type="file" :value="$partner?->logo_path" hint="Shown centred on the front of the card. A transparent PNG works best." />
</div>

<x-admin.translatable-field
    name="role"
    label="Role / impact for SATFYF"
    :translations="$partner?->translations('role') ?? []"
    hint="A short phrase shown as a tag under the name, e.g. 'Funds youth ambassador training'."
    class="mt-5"
/>

<x-admin.translatable-field
    name="description"
    label="Description"
    type="textarea"
    :translations="$partner?->translations('description') ?? []"
    hint="Shown on the back of the card when a visitor hovers or taps it. Two to four sentences reads best; longer text scrolls inside the card."
    class="mt-5"
/>

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="order" label="Order" type="number" :value="$partner?->order ?? 0" hint="Lowest first within its section." />
    <x-admin.field name="published" label="Published" type="checkbox" :value="$partner?->published ?? true" />
</div>

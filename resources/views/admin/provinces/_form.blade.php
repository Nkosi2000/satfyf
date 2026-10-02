@php($province = $province ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="name" label="Name" :value="$province?->name" />
    <x-admin.field name="order" label="Order" type="number" :value="$province?->order ?? 0" />
</div>

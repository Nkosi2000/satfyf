@props([
    'name',
    'label',
    'translations' => [],
    'type' => 'text',
    'hint' => null,
])

@php
    $localeLabels = ['zu' => 'isiZulu', 'st' => 'Sesotho', 'af' => 'Afrikaans'];
@endphp

<div {{ $attributes }}>
    <x-admin.field :name="$name.'[en]'" :label="$label.' (English)'" :type="$type" :value="$translations['en'] ?? null" :hint="$hint" />

    @foreach ($localeLabels as $code => $localeLabel)
        <details class="mt-2 rounded-lg border border-hairline-strong">
            <summary class="cursor-pointer px-3 py-2 text-sm font-medium text-fg">{{ $label }} ({{ $localeLabel }})</summary>
            <div class="p-3 pt-0">
                <x-admin.field :name="$name.'['.$code.']'" :label="$label.' ('.$localeLabel.')'" :type="$type" :value="$translations[$code] ?? null" />
            </div>
        </details>
    @endforeach
</div>

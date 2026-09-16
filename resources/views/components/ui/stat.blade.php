@props(['value', 'label'])

@php
    $animated = preg_match('/\d/', (string) $value);
@endphp

<div {{ $attributes->class(['flex flex-col gap-1']) }}>
    <span class="text-4xl text-fg sm:text-5xl" @if ($animated) data-count-to="{{ $value }}" @endif>{{ $animated ? '0' : $value }}</span>
    <span class="text-sm text-muted">{{ $label }}</span>
</div>

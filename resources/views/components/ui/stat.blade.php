@props(['value', 'label', 'invert' => false])

@php
    $animated = preg_match('/\d/', (string) $value);
@endphp

<div {{ $attributes->class(['flex flex-col gap-1']) }}>
    <span class="text-5xl font-black sm:text-6xl {{ $invert ? 'text-on-accent' : 'text-fg' }}" @if ($animated) data-count-to="{{ $value }}" @endif>{{ $animated ? '0' : $value }}</span>
    <span class="text-sm font-bold tracking-wide uppercase {{ $invert ? 'text-on-accent/70' : 'text-muted' }}">{{ $label }}</span>
</div>

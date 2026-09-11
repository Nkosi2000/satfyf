@props(['tone' => 'primary'])

@php
    $tones = [
        'primary' => 'from-primary/25',
        'secondary' => 'from-secondary-soft/25',
        'tertiary' => 'from-tertiary/20',
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class([
        'pointer-events-none absolute rounded-full blur-3xl bg-radial to-transparent',
        $tones[$tone] ?? $tones['primary'],
    ]) }}
></div>

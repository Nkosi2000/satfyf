@props(['tone' => 'ember'])

@php
    $tones = [
        'ember' => 'from-ember/35',
        'signal' => 'from-signal/30',
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class([
        'pointer-events-none absolute rounded-full blur-3xl bg-radial to-transparent',
        $tones[$tone] ?? $tones['ember'],
    ]) }}
></div>

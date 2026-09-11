@props([
    'width' => 'default',
])

@php
    $widths = [
        'default' => 'max-w-6xl',
        'narrow' => 'max-w-3xl',
        'wide' => 'max-w-7xl',
    ];
@endphp

<section {{ $attributes->class(['py-20 sm:py-28']) }}>
    <div class="mx-auto w-full {{ $widths[$width] ?? $widths['default'] }} px-6">
        {{ $slot }}
    </div>
</section>

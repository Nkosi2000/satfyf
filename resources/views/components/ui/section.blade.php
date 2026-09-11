@props([
    'width' => 'default',
])

@php
    // Wider than the original scale (was 80/96/52rem) so the page still
    // reads as roomier on common laptop/desktop screens, but every variant
    // caps out on very large monitors instead of stretching indefinitely —
    // fully uncapped content read as too thin/spread out once tested wide.
    $widths = [
        'default' => 'max-w-[100rem]',
        'narrow' => 'max-w-[52rem]',
        'wide' => 'max-w-[120rem]',
    ];
@endphp

<section {{ $attributes->class(['py-24 sm:py-32']) }}>
    <div class="mx-auto w-full {{ $widths[$width] ?? $widths['default'] }} px-6 sm:px-8">
        {{ $slot }}
    </div>
</section>

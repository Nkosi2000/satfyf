@props([
    'width' => 'default',
    // Optional corner for the brand triangle pattern (see
    // x-ui.triangle-pattern): top-right | top-left | bottom-right | bottom-left.
    'triangles' => null,
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

<section {{ $attributes->class(['py-24 sm:py-32', 'relative overflow-hidden' => $triangles]) }}>
    @if ($triangles)
        <x-ui.triangle-pattern :corner="$triangles" class="opacity-35" />
    @endif
    <div class="relative mx-auto w-full {{ $widths[$width] ?? $widths['default'] }} px-6 sm:px-8">
        {{ $slot }}
    </div>
</section>

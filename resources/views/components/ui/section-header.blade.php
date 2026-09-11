@props([
    'eyebrow' => null,
    'accent' => null,
    'align' => 'left',
    'reveal' => true,
])

<div {{ $attributes->class(['max-w-2xl', 'text-center mx-auto' => $align === 'center', 'reveal' => $reveal]) }}>
    @if ($eyebrow)
        <x-ui.eyebrow class="mb-4">{{ $eyebrow }}</x-ui.eyebrow>
    @endif

    <h2 class="text-balance font-serif text-4xl leading-[1.1] text-fg sm:text-5xl">
        {{ $slot }}
        @if ($accent)
            <span class="text-primary-soft">{{ $accent }}</span>
        @endif
    </h2>
</div>

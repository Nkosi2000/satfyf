@props([
    'eyebrow' => null,
    'accent' => null,
    'align' => 'left',
    'reveal' => true,
    'soft' => false,
    'wide' => false,
])

{{-- `wide` lets a heading spread further across the page before wrapping;
     max-w-2xl alone is only ~440px under the site's 65% root font-size. --}}
<div {{ $attributes->class(['max-w-2xl' => ! $wide, 'max-w-7xl' => $wide, 'text-center mx-auto' => $align === 'center', 'reveal' => $reveal]) }}>
    @if ($eyebrow)
        <x-ui.eyebrow class="mb-4" :soft="$soft">{{ $eyebrow }}</x-ui.eyebrow>
    @endif

    <h2 class="font-display text-balance text-5xl leading-[1] tracking-tight text-fg sm:text-6xl">
        {{ $slot }}
        @if ($accent)
            <span class="text-primary-soft">{{ $accent }}</span>
        @endif
    </h2>
</div>

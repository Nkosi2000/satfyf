@props([
    'eyebrow' => null,
    'accent' => null,
    'align' => 'left',
    'reveal' => true,
    'soft' => false,
    'wide' => false,
])

{{-- `wide` lets a heading use the section's full width (max-w-2xl alone is
     only ~440px under the site's 65% root font-size), and swaps
     text-balance — which evens out line lengths and so shortens every
     line — for text-pretty, so lines run to the right-hand edge. --}}
<div {{ $attributes->class(['max-w-2xl' => ! $wide, 'text-center mx-auto' => $align === 'center', 'reveal' => $reveal]) }}>
    @if ($eyebrow)
        <x-ui.eyebrow class="mb-4" :soft="$soft">{{ $eyebrow }}</x-ui.eyebrow>
    @endif

    <h2 @class(['font-display text-5xl leading-[1.1] font-semibold tracking-tight text-fg sm:text-6xl', 'text-balance' => ! $wide, 'text-pretty' => $wide])>
        {{ $slot }}
        @if ($accent)
            <span class="text-primary-soft">{{ $accent }}</span>
        @endif
    </h2>
</div>

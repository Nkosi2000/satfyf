@props([
    'eyebrow' => null,
    'accent' => null,
    'align' => 'left',
    'reveal' => true,
    'soft' => false,
])

<div {{ $attributes->class(['max-w-2xl', 'text-center mx-auto' => $align === 'center', 'reveal' => $reveal]) }}>
    @if ($eyebrow)
        <x-ui.eyebrow class="mb-4" :soft="$soft">{{ $eyebrow }}</x-ui.eyebrow>
    @endif

    <h2 class="text-balance text-5xl leading-[1] font-black tracking-tight text-fg sm:text-6xl">
        {{ $slot }}
        @if ($accent)
            <span class="text-primary-soft">{{ $accent }}</span>
        @endif
    </h2>
</div>

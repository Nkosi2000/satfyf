@props(['wide' => false])

{{-- Intro paragraph under an <x-ui.section-header>. Pair `wide` with the
     header's own `wide` so the text spreads as far as the heading does. --}}
<p {{ $attributes->class([
    'text-balance text-lg leading-relaxed text-muted sm:text-xl',
    'max-w-2xl' => ! $wide,
    'max-w-6xl' => $wide,
]) }}>{{ $slot }}</p>

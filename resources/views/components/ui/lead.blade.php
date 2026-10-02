@props(['wide' => false])

{{-- Intro paragraph under an <x-ui.section-header>. Pair `wide` with the
     header's own `wide` so the text spreads across the section's full width
     too — text-pretty instead of text-balance, since balancing shortens
     every line and leaves empty space on the right. --}}
<p {{ $attributes->class([
    'text-lg leading-relaxed text-muted sm:text-xl',
    'max-w-2xl text-balance' => ! $wide,
    'text-pretty' => $wide,
]) }}>{{ $slot }}</p>

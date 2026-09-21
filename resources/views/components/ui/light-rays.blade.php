@props([
    // diagonal: four crossing beams, the boldest variant (hero, closing
    // CTA). vertical: six near-vertical spotlight beams, tuned for a dark
    // background (the Stats block). sweep: two or three very wide, very
    // soft bands that drift sideways — the subtlest variant, for sitting
    // behind real page content (the shared page-hero).
    'variant' => 'diagonal',
])

@php
    $spanCounts = ['diagonal' => 4, 'vertical' => 6, 'sweep' => 3];
    $count = $spanCounts[$variant] ?? 4;
@endphp

{{--
    Slow-drifting light beams (see .light-rays / .light-rays--{variant} in
    app.css) — replaces the earlier floating-particle "embers" effect,
    which read as bubbles rather than the intended spark look. Fixed
    colours/angles/counts per variant, set in CSS; non-interactive and
    purely decorative.
--}}
<div {{ $attributes->class(['light-rays', "light-rays--{$variant}"]) }} aria-hidden="true">
    @for ($i = 0; $i < $count; $i++)
        <span></span>
    @endfor
</div>

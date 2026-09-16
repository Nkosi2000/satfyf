@props([
    'palette' => ['#8a8680', '#4d4a45'],
    'bg' => '#000000',
    'bgAlpha' => 0,
    'speed' => 0.3,
    'scale' => 1,
    'warp' => 1,
    'rise' => 0.3,
    'swirl' => 0.3,
    'contrast' => 1.3,
    'softness' => 0.55,
    'mouse' => 0.3,
])

{{--
    Real-time WebGL "fluid smoke" backdrop — domain-warped noise shaped into
    soft volumetric plumes (see resources/js/modules/fluid-smoke.js for the
    shader). Transparent by default (bg-alpha 0), so it's meant to sit
    inside a section that already has its own background — the footer, say
    — rather than behave as a standalone panel. The gradient below is a
    plain CSS fallback shown until the canvas paints its first frame, and
    stays visible if WebGL isn't available.
--}}
<div {{ $attributes->class(['fluid-smoke-fallback pointer-events-none absolute inset-0 overflow-hidden']) }} aria-hidden="true">
    <canvas
        data-fluid-smoke
        data-palette="{{ implode(',', $palette) }}"
        data-bg="{{ $bg }}"
        data-bg-alpha="{{ $bgAlpha }}"
        data-speed="{{ $speed }}"
        data-scale="{{ $scale }}"
        data-warp="{{ $warp }}"
        data-rise="{{ $rise }}"
        data-swirl="{{ $swirl }}"
        data-contrast="{{ $contrast }}"
        data-softness="{{ $softness }}"
        data-mouse="{{ $mouse }}"
        class="block h-full w-full"
    ></canvas>
</div>

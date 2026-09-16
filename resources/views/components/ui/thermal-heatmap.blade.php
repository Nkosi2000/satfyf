@props([
    'palette' => ['#000004', '#420a68', '#932667', '#dd513a', '#fca50a', '#fcffa4'],
    'bg' => '#050208',
    'bgAlpha' => 0.55,
    'speed' => 0.35,
    'scale' => 1,
    'hotspots' => 3,
    'glow' => 1,
    'flow' => 0.4,
    'contrast' => 1.2,
    'contours' => 0,
    'mouse' => 0.5,
])

{{--
    Real-time WebGL "thermal heatmap" backdrop — a domain-warped noise field
    mapped through a cold-to-hot palette, with pulsing hotspot blooms and an
    optional cursor-pressed thermal bloom that cools back down at rest (see
    resources/js/modules/thermal-heatmap.js for the shader). Composited with
    real alpha transparency like x-ui.fluid-smoke, so cold regions can fade
    into the host section's own background rather than always painting a
    solid panel. The gradient below is a plain CSS fallback shown until the
    canvas paints its first frame, and stays visible if WebGL isn't
    available at all.
--}}
<div {{ $attributes->class(['thermal-heatmap-fallback absolute inset-0 overflow-hidden']) }} aria-hidden="true">
    <canvas
        data-thermal-heatmap
        data-palette="{{ implode(',', $palette) }}"
        data-bg="{{ $bg }}"
        data-bg-alpha="{{ $bgAlpha }}"
        data-speed="{{ $speed }}"
        data-scale="{{ $scale }}"
        data-hotspots="{{ $hotspots }}"
        data-glow="{{ $glow }}"
        data-flow="{{ $flow }}"
        data-contrast="{{ $contrast }}"
        data-contours="{{ $contours }}"
        data-mouse="{{ $mouse }}"
        class="block h-full w-full"
    ></canvas>
</div>

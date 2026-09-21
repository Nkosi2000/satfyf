@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    // Opt-in pointer-tracking pull (resources/js/modules/magnetic.js) for
    // the handful of hero-level CTAs that should feel like the site's
    // single boldest interactive moment — not the default for every button,
    // since that would cheapen it. Non-magnetic buttons still get a plain
    // CSS hover scale, just without the cursor-following pull.
    'magnetic' => false,
])

@php
    // Primary is the brand-red fill with a glowing shadow lift on hover —
    // the site's boldest, most attention-grabbing interactive moment.
    // Secondary is a hairline outline that still picks up a lift on hover.
    // Ghost stays plain, reading quieter than either.
    $base = 'inline-flex items-center justify-center gap-2 rounded-full font-bold transition-[transform,filter,background-color] duration-200 ease-out disabled:opacity-50 disabled:pointer-events-none';

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-7 py-4 text-base',
    ];

    // The magnetic module owns transform entirely once it's attached (an
    // inline style always beats a class's transform, hover or not), so a
    // magnetic button skips the CSS hover:scale it would otherwise fight.
    $variants = [
        'primary' => 'press bg-primary text-on-accent hover:brightness-110'.($magnetic ? '' : ' hover:scale-105'),
        'secondary' => 'press border border-hairline-strong bg-surface text-fg hover:-translate-y-0.5 hover:bg-surface-2',
        'ghost' => 'text-muted hover:text-fg',
        // For use on a saturated/dark background (e.g. the closing CTA's
        // red block) where the primary-red fill would vanish into it.
        'invert' => 'press bg-cream text-fg'.($magnetic ? '' : ' hover:scale-105'),
    ];

    $shadowStyle = in_array($variant, ['primary', 'invert'], true) ? 'box-shadow: var(--shadow-soft-sm)' : null;

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);

    $extraAttributes = array_filter([
        'class' => $classes,
        'style' => $shadowStyle,
        'data-magnetic' => $magnetic ? '' : null,
    ], fn ($value) => $value !== null);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge($extraAttributes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge($extraAttributes) }}>
        {{ $slot }}
    </button>
@endif

@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-full font-medium transition duration-150 ease-out active:scale-[0.97] disabled:opacity-50 disabled:pointer-events-none disabled:active:scale-100';

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3.5 text-base',
    ];

    $variants = [
        'primary' => 'bg-gradient-to-b from-primary-soft to-primary text-on-accent shadow-[0_1px_0_0_rgba(255,255,255,0.3)_inset,0_8px_24px_-8px_rgb(var(--color-primary-rgb)/0.45)] hover:brightness-105 active:brightness-95',
        'secondary' => 'border border-hairline-strong text-fg hover:bg-surface hover:border-fg/30',
        'ghost' => 'text-muted hover:text-fg',
    ];

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

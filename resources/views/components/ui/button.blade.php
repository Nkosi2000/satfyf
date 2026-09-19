@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    // Primary/secondary get the press-physics treatment: a thick border and
    // a hard offset shadow that the button shoves flat into on pointer-down
    // (see .press in app.css) — feedback on the press itself, not just the
    // click. Ghost stays plain since it's meant to read as quieter than the
    // other two, not as another physical object.
    $base = 'inline-flex items-center justify-center gap-2 rounded-full font-bold transition-colors duration-150 ease-out disabled:opacity-50 disabled:pointer-events-none';

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-7 py-4 text-base',
    ];

    $variants = [
        'primary' => 'press border-[3px] border-fg bg-primary text-on-accent shadow-[6px_6px_0_0_var(--shadow-hard-color)] hover:brightness-105',
        'secondary' => 'press border-[3px] border-fg bg-surface text-fg shadow-[6px_6px_0_0_var(--shadow-hard-color)]',
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

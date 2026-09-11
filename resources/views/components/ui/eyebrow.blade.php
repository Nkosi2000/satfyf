@props(['icon' => null])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 text-xs font-medium tracking-[0.14em] uppercase text-signal']) }}>
    @if ($icon)
        <span class="h-1.5 w-1.5 rounded-full bg-signal"></span>
    @endif
    {{ $slot }}
</span>

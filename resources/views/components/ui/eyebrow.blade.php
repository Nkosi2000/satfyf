@props(['icon' => null])

{{-- Text is hardcoded black (not the adaptive text-fg) — the yellow fill
     behind it needs dark text for contrast in both themes, since fg flips
     to white in dark mode and would fail against this exact yellow. --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-full border-[3px] border-fg bg-secondary-soft px-3 py-1 text-xs font-bold tracking-[0.1em] text-black uppercase']) }}>
    @if ($icon)
        <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
    @endif
    {{ $slot }}
</span>

@props(['active' => false])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full border-[3px] border-fg px-3.5 py-1.5 text-xs font-bold transition',
    'bg-primary text-on-accent' => $active,
    'bg-surface text-muted' => ! $active,
]) }}>
    {{ $slot }}
</span>

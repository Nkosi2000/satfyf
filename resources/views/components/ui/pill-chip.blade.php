@props(['active' => false])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full border border-hairline-strong px-3.5 py-1.5 text-xs font-bold transition',
    'bg-primary text-on-accent border-transparent' => $active,
    'bg-surface text-muted' => ! $active,
]) }}>
    {{ $slot }}
</span>

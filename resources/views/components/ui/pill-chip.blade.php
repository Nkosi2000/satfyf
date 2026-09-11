@props(['active' => false])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full px-3.5 py-1.5 text-xs font-medium transition',
    'bg-ember text-ink' => $active,
    'border border-hairline-strong text-muted' => ! $active,
]) }}>
    {{ $slot }}
</span>

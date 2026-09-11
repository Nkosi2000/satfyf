@props(['padded' => true, 'lift' => true])

<div {{ $attributes->class([
    'rounded-2xl border border-hairline bg-surface/60',
    'p-6' => $padded,
    'hover-lift' => $lift,
]) }}>
    {{ $slot }}
</div>

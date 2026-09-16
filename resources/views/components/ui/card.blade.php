@props(['padded' => true, 'lift' => true])

<div {{ $attributes->class([
    'glass rounded-2xl border border-hairline',
    'p-6' => $padded,
    'hover-lift' => $lift,
]) }}>
    {{ $slot }}
</div>

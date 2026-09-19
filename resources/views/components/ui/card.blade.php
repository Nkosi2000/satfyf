@props(['padded' => true])

<div {{ $attributes->class([
    'card-hard',
    'p-6' => $padded,
]) }}>
    {{ $slot }}
</div>

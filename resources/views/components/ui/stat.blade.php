@props(['value', 'label'])

<div {{ $attributes->class(['flex flex-col gap-1']) }}>
    <span class="font-serif text-4xl text-cream sm:text-5xl">{{ $value }}</span>
    <span class="text-sm text-muted">{{ $label }}</span>
</div>

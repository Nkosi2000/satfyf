@props(['title', 'href' => null, 'linkLabel' => null, 'external' => false])

{{-- Title + body card, optionally ending in a link. Used for steps, roles,
     ways-in and publication lists across the content pages. --}}
<x-ui.card {{ $attributes->class(['flex flex-col']) }}>
    <p class="text-2xl font-bold text-fg">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <p class="mt-2 flex-1 text-base leading-relaxed text-muted">{{ $slot }}</p>
    @endif
    @if ($href)
        <a
            href="{{ $href }}"
            @if ($external) target="_blank" rel="noopener noreferrer" @endif
            class="mt-4 text-base font-bold text-primary-soft hover:underline"
        >
            {{ $linkLabel ?? __('Learn more') }} &rarr;
        </a>
    @endif
</x-ui.card>

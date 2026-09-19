{{--
    A real ISO no-smoking sign image, framed like a physical sign mounted
    on the page — the card-hard border/shadow around it is the "frame",
    on top of the thin border already baked into the source image itself.
--}}
<div {{ $attributes->class(['card-hard flex aspect-square items-center justify-center overflow-hidden bg-surface p-4']) }}>
    <img src="{{ asset('images/SM1 - No Smoking Sign.png') }}" alt="{{ __('No smoking') }}" class="h-full w-full object-contain" />
</div>

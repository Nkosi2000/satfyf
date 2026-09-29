@props(['muted' => false])

{{-- Title line for an <x-ui.link-row>. Sized explicitly: the site's 65%
     root font-size makes unsized text render ~10px. `muted` is for
     de-emphasised rows such as past events. --}}
<p {{ $attributes->class([
    'text-xl font-bold sm:text-2xl',
    'text-fg group-hover:text-primary-soft' => ! $muted,
    'text-muted group-hover:text-fg' => $muted,
]) }}>{{ $slot }}</p>

@props(['strong' => false])

{{-- Body text for a card or list item. Sized explicitly: the site's 65%
     root font-size makes unsized text render ~10px. `strong` is for short,
     label-like content such as goals or province names. --}}
<p {{ $attributes->class([
    'text-lg leading-relaxed text-fg sm:text-xl',
    'font-bold' => $strong,
]) }}>{{ $slot }}</p>

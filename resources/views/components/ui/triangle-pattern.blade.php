@props([
    // top-right | top-left | bottom-right | bottom-left
    'corner' => 'top-right',
])

{{--
    The brand letterhead's red ▲ ▼ triangle grid, fading out from one corner
    of its parent (which must be position: relative). Purely decorative —
    see .triangle-pattern in app.css.
--}}
<div data-triangle-pattern {{ $attributes->class(['triangle-pattern', 'triangle-pattern--'.$corner]) }} aria-hidden="true"></div>

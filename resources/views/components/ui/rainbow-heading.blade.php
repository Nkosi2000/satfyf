@props([
    'line1',
    'line2' => null,
])

{{--
    Colors every word across both lines with a continuous cycle through the
    brand's WCAG-safe text tokens (the plain, non-"-soft" role — see the
    contrast notes in app.css) so the heading reads as a run of brand hues
    rather than one accent color.
--}}
@php
    $rainbowColors = ['text-primary', 'text-danger', 'text-secondary', 'text-tertiary', 'text-orange', 'text-brown'];
    $wordIndex = 0;

    $colorWords = function (string $text) use ($rainbowColors, &$wordIndex): string {
        return collect(preg_split('/\s+/', trim($text)))
            ->map(function (string $word) use ($rainbowColors, &$wordIndex) {
                $color = $rainbowColors[$wordIndex % count($rainbowColors)];
                $wordIndex++;

                return '<span class="'.$color.'">'.e($word).'</span>';
            })
            ->implode(' ');
    };
@endphp

{!! $colorWords($line1) !!}
@if ($line2)
    <span class="block">{!! $colorWords($line2) !!}</span>
@endif

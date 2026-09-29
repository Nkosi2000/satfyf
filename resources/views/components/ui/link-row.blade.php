@props(['href'])

{{-- Shared linked list row (glass hover strip). Layout — display, padding,
     dividers — is left to the call site via `class`, since rows sit in
     stacked lists, grids and split flex layouts. --}}
<a href="{{ $href }}" {{ $attributes->class(['group glass-row row-hover pl-5']) }}>
    {{ $slot }}
</a>

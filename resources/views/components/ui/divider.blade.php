@props(['vertical' => false])

@if ($vertical)
    <div {{ $attributes->merge(['class' => 'w-px self-stretch bg-hairline']) }}></div>
@else
    <div {{ $attributes->merge(['class' => 'h-px w-full bg-hairline']) }}></div>
@endif

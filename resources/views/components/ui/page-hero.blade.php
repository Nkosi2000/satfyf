@props([
    'eyebrow',
    'subtext' => null,
])

{{--
    Shared page-header pattern: every inner page (everything except the
    homepage, whose hero is its own two-column layout) opens with the same
    eyebrow + <h1> + optional subtext, narrow column, fade-in on load. One
    component instead of this block repeated verbatim across ten pages.
--}}
<section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
    <x-ui.section class="relative !py-0" width="wide">
        <div class="hero-enter">
            <x-ui.eyebrow>{{ $eyebrow }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance text-5xl leading-[1.05] text-fg sm:text-6xl">
                {{ $slot }}
            </h1>
            @if ($subtext)
                <p class="mt-6 text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $subtext }}</p>
            @endif
        </div>
    </x-ui.section>
</section>

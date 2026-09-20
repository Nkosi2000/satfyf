@props([
    'eyebrow',
    'subtext' => null,
])

{{--
    Shared page-header pattern: every inner page (everything except the
    homepage, whose hero is its own two-column layout) opens with the same
    eyebrow + <h1> + optional subtext, narrow column, fade-in on load. One
    component instead of this block repeated verbatim across ten pages.

    The $image slot is opt-in (only who-we-are.blade.php uses it, for the
    same light/dark logo lockup as the homepage's "Why It Matters" section)
    — every other page passes nothing and keeps the original single-column
    layout untouched.
--}}
<section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
    <x-ui.section class="relative !py-0" width="wide">
        @isset($image)
            <div class="grid items-center gap-12 lg:grid-cols-[1fr_1fr]">
                <div class="hero-enter">
                    <x-ui.eyebrow>{{ $eyebrow }}</x-ui.eyebrow>
                    <h1 class="mt-5 text-balance text-5xl leading-[0.98] font-black tracking-tight text-fg sm:text-6xl">
                        {{ $slot }}
                    </h1>
                    @if ($subtext)
                        <p class="mt-6 text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $subtext }}</p>
                    @endif
                </div>

                {{-- The image sits one level deeper than .hero-enter's direct
                     children on purpose: the global image-shimmer rules
                     (img[data-loaded] in app.css) have higher specificity
                     than .hero-enter > *, so once the logo finishes loading
                     that rule's `animation: none` cancels the hero-rise
                     entrance outright and leaves the image stuck at
                     opacity: 0. Wrapping it in a plain div keeps the <img>
                     out of that selector entirely — the wrapper still
                     fades/rises as one unit, carrying the image with it. --}}
                <div class="hero-enter mx-auto w-full max-w-2xl">
                    <div>
                        {{ $image }}
                    </div>
                </div>
            </div>
        @else
            <div class="hero-enter">
                <x-ui.eyebrow>{{ $eyebrow }}</x-ui.eyebrow>
                <h1 class="mt-5 text-balance text-5xl leading-[0.98] font-black tracking-tight text-fg sm:text-6xl">
                    {{ $slot }}
                </h1>
                @if ($subtext)
                    <p class="mt-6 text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $subtext }}</p>
                @endif
            </div>
        @endif
    </x-ui.section>
</section>

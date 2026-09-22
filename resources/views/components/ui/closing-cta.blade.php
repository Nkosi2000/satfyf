@props(['sideImage' => false])

@php
    $hero = \App\Models\SiteSetting::group('hero');
@endphp

{{-- Shared closing CTA: the boldest, most saturated moment on every page
     that has one — a full-bleed brand-red block with a glowing radial
     backdrop, mirroring the homepage Stats section's one deliberate dark
     beat but built from the primary red instead of near-black. Fixed
     colours regardless of site theme (not theme-relative), since the
     point is a consistent, committed colour block, not "whichever shade
     opposes the current toggle". sideImage is opt-in (no page currently
     passes it) for the one page that might want the no-smoking-sign motif
     alongside the block rather than every closing CTA repeating it. --}}
<section class="relative overflow-hidden px-6 py-20 sm:px-8 sm:py-28" style="background-color: var(--color-primary-deep)">
    <div
        class="pointer-events-none absolute inset-0"
        style="background-image: radial-gradient(ellipse 65% 55% at 25% 20%, color-mix(in oklab, var(--color-primary) 55%, transparent), transparent), radial-gradient(ellipse 55% 55% at 80% 85%, color-mix(in oklab, var(--color-secondary) 45%, transparent), transparent)"
        aria-hidden="true"
    ></div>
    <x-ui.light-rays class="opacity-70" />

    <div @class([
        'relative mx-auto w-full max-w-[110rem] text-center' => ! $sideImage,
        'relative mx-auto grid w-full max-w-[110rem] items-center gap-12 lg:grid-cols-[0.4fr_0.6fr]' => $sideImage,
    ])>
        @if ($sideImage)
            <div class="mx-auto w-full max-w-[14rem]">
                <x-ui.no-smoking-sign />
            </div>
        @endif

        <div @class([
            'flex flex-col items-center gap-6 text-center' => true,
        ])>
            <h2 class="font-display text-balance text-5xl leading-[1] tracking-tight text-on-accent sm:text-6xl lg:text-7xl">
                {{ $hero['hero_heading'] ?? __('Speak up. Stand out.') }}
                <span style="color: var(--color-secondary-soft)">{{ $hero['hero_heading_accent'] ?? __('A smoke-free generation.') }}</span>
            </h2>
            <p class="max-w-xl text-balance text-lg leading-relaxed" style="color: color-mix(in oklab, var(--color-on-accent) 78%, transparent)">
                {{ __('No membership fee. Open to every school and community.') }}
            </p>
            <x-ui.button href="{{ route('get-involved') }}" variant="invert" size="lg" class="mt-2" magnetic>{{ __('Get Involved') }}</x-ui.button>
        </div>
    </div>
</section>

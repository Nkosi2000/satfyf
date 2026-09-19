@props(['sideImage' => false])

@php
    $hero = \App\Models\SiteSetting::group('hero');
@endphp

{{-- Shared closing CTA: same heading, button and subtext on every page that has one. --}}
{{--
    Deliberately stays on the page's normal surface rather than an inverted
    block: rainbow-heading's per-word colours are calibrated for contrast
    against the page background specifically (see its own comment), so
    flipping this section to a dark block would leave several of those
    words unreadable against their own now-inverted background.

    sideImage is opt-in (only the homepage passes it) rather than applied
    everywhere this component renders — this same block appears on several
    pages, and a literal no-smoking sign next to every one of them would
    read as repetition rather than reinforcement. See conversation context:
    one high-impact placement beats the icon showing up on every CTA.
--}}
<section class="relative overflow-hidden border-t-[3px] border-b-[3px] border-fg py-24">
    <div class="mx-auto w-full max-w-[120rem] px-6 sm:px-8">
        <div @class(['reveal mx-auto grid max-w-xl items-center gap-12 text-center' => ! $sideImage, 'reveal-stagger grid items-center gap-12 lg:grid-cols-[0.4fr_0.6fr]' => $sideImage])>
            @if ($sideImage)
                <div class="mx-auto w-full max-w-[14rem]">
                    <x-ui.no-smoking-sign />
                </div>
            @endif

            <div @class(['text-center' => ! $sideImage, 'text-center lg:text-left' => $sideImage])>
                <h2 class="text-balance text-4xl font-black tracking-tight sm:text-6xl">
                    <x-ui.rainbow-heading
                        :line1="$hero['hero_heading'] ?? __('Speak up. Stand out.')"
                        :line2="$hero['hero_heading_accent'] ?? __('A smoke-free generation.')"
                    />
                </h2>
                <div @class(['mt-8 flex justify-center' => ! $sideImage, 'mt-8 flex justify-center lg:justify-start' => $sideImage])>
                    <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
                </div>
                <p class="mt-4 text-sm font-bold text-faint">{{ __('No membership fee. Open to every school and community.') }}</p>
            </div>
        </div>
    </div>
</section>

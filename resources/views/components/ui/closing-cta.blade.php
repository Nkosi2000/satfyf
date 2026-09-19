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
--}}
<section class="relative overflow-hidden border-t-[3px] border-b-[3px] border-fg py-24 text-center">
    <div class="reveal relative mx-auto max-w-xl px-6">
        <h2 class="text-balance text-4xl font-black tracking-tight sm:text-6xl">
            <x-ui.rainbow-heading
                :line1="$hero['hero_heading'] ?? __('Speak up. Stand out.')"
                :line2="$hero['hero_heading_accent'] ?? __('A smoke-free generation.')"
            />
        </h2>
        <div class="mt-8 flex justify-center">
            <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
        </div>
        <p class="mt-4 text-sm font-bold text-faint">{{ __('No membership fee. Open to every school and community.') }}</p>
    </div>
</section>

<x-layouts.app :title="__('Why We Exist')">
    <section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
        <x-ui.glow tone="primary" class="-top-24 right-0 h-96 w-96 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>{{ __('Why We Exist') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">
                {{ __("Tobacco doesn't market itself to adults.") }}
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                {{ __("Tobacco use carries real health harms, real economic costs, and it still starts young. In a country still building the policy and enforcement to protect its youth, silence isn't neutral — it's a gap the industry is glad to fill.") }}
            </p>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t">
        <div class="reveal-stagger grid gap-10 sm:grid-cols-3">
            <div>
                <p class="font-serif text-3xl text-primary-soft">{{ __('Health') }}</p>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ __("Nicotine takes hold fastest in adolescent brains, and the harms of smoking compound over a lifetime that's only just starting.") }}</p>
            </div>
            <div>
                <p class="font-serif text-3xl text-primary-soft">{{ __('Economic') }}</p>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ __('Every rand spent on tobacco is a rand not spent on education, health or savings — a cost that falls hardest on households that can least afford it.') }}</p>
            </div>
            <div>
                <p class="font-serif text-3xl text-primary-soft">{{ __('Policy') }}</p>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ __("South Africa's tobacco control policy is still catching up. Youth voices in that process are what keep it honest and enforced.") }}</p>
            </div>
        </div>
    </x-ui.section>

    <x-ui.section class="hairline-t" width="narrow">
        <x-ui.section-header eyebrow="{{ __('How We Respond') }}">
            {{ __("We don't just warn. We show up.") }}
        </x-ui.section-header>
        <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
            {{ __('Think sessions, social media conversations, media advocacy, public demonstrations and Community Imbizos — SATFYF meets young people in the spaces they already occupy, with facts instead of fear.') }}
        </p>
        <div class="mt-8">
            <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">{{ __('See how we work') }}</x-ui.button>
        </div>
    </x-ui.section>
</x-layouts.app>

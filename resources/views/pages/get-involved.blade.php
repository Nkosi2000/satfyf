<x-layouts.app :title="__('Get Involved')">
    <section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
        <x-ui.glow tone="primary" class="-top-24 left-1/2 h-96 w-96 -translate-x-1/2 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>{{ __('Get Involved') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">
                {{ __('Help achieve a culture where young people reject tobacco.') }}
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                {{ __("There's no membership fee, and no single way in. Pick what fits.") }}
            </p>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t">
        <div class="reveal-stagger grid gap-6 sm:grid-cols-2">
            <x-ui.card>
                <p class="font-serif text-2xl text-fg">{{ __('Start a Think Session') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-muted">{{ __('Bring a facilitated conversation about tobacco and substance abuse to your school or youth group.') }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="font-serif text-2xl text-fg">{{ __('Become a Youth Ambassador') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-muted">{{ __('Get trained to run campaigns, speak at events and lead in your own community.') }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="font-serif text-2xl text-fg">{{ __('Host a Community Imbizo') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-muted">{{ __('Bring parents, teachers and local leaders together for an honest conversation.') }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="font-serif text-2xl text-fg">{{ __('Partner with SATFYF') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-muted">{{ __('Organisations and donors — see how a partnership could work.') }}</p>
            </x-ui.card>
        </div>
    </x-ui.section>

    <x-ui.section class="hairline-t" width="narrow">
        <x-ui.section-header eyebrow="{{ __('Reach Out') }}">{{ __("Tell us what you'd like to do.") }}</x-ui.section-header>
        <x-contact-form subject="Getting involved" class="mt-8" />
    </x-ui.section>

    @if ($faqs->isNotEmpty())
        <x-ui.section class="hairline-t" width="narrow">
            <x-ui.section-header>{{ __('Questions.') }}</x-ui.section-header>
            <x-ui.accordion class="reveal-stagger mt-8">
                @foreach ($faqs as $faq)
                    <x-ui.accordion-item :question="$faq->question">{{ $faq->answer }}</x-ui.accordion-item>
                @endforeach
            </x-ui.accordion>
        </x-ui.section>
    @endif
</x-layouts.app>

<x-layouts.app :title="__('What We Do')">
    <section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
        <x-ui.glow tone="tertiary" class="-top-24 left-0 h-96 w-96 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>{{ __('What We Do') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">
                {{ __('Every programme, grouped by purpose.') }}
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                {{ __('From think sessions to public demonstrations — each programme is built to meet young people where they are.') }}
            </p>
        </x-ui.section>
    </section>

    @foreach ($grouped as $group)
        <x-ui.section class="hairline-t">
            <x-ui.section-header :eyebrow="$group['category']->label()">
                {{ trans_choice(':count programme|:count programmes', $group['programs']->count(), ['count' => $group['programs']->count()]) }}
            </x-ui.section-header>

            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($group['programs'] as $program)
                    <div class="grid gap-2 py-6 hairline-b sm:grid-cols-[1fr_2fr] sm:gap-8">
                        <p class="font-medium text-fg">{{ $program->title }}</p>
                        <p class="max-w-2xl text-sm leading-relaxed text-muted">{{ $program->description }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endforeach

    <section class="hairline-t py-24 text-center sm:py-32">
        <p class="text-balance font-serif text-3xl text-fg">{{ __('Want a programme running at your school?') }}</p>
        <div class="mt-8">
            <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
        </div>
    </section>
</x-layouts.app>

<x-layouts.app :title="__('What We Do')">
    <x-ui.page-hero eyebrow="{{ __('What We Do') }}" subtext="{{ __('From think sessions to public demonstrations — each programme is built to meet young people where they are.') }}">
        {{ __('Every programme, grouped by purpose.') }}
    </x-ui.page-hero>

    @foreach ($grouped as $group)
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="$group['category']->label()">
                {{ trans_choice(':count programme|:count programmes', $group['programs']->count(), ['count' => $group['programs']->count()]) }}
            </x-ui.section-header>

            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($group['programs'] as $program)
                    <div class="glass-row grid gap-2 py-6 hairline-b hover:glass sm:grid-cols-[1fr_2fr] sm:gap-8">
                        <p class="font-medium text-fg">{{ $program->title }}</p>
                        <p class="max-w-2xl text-sm leading-relaxed text-muted">{{ $program->description }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endforeach

    <section class="relative hairline-t overflow-hidden py-24 text-center sm:py-32">
        <div class="reveal relative">
            <p class="text-balance text-3xl text-fg">{{ __('Want a programme running at your school?') }}</p>
            <div class="mt-8">
                <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
            </div>
        </div>
    </section>
</x-layouts.app>

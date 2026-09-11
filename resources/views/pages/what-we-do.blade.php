@use('Illuminate\Support\Str')

<x-layouts.app title="What We Do">
    <section class="relative overflow-hidden pt-20 pb-16 sm:pt-28">
        <x-ui.glow tone="signal" class="-top-24 left-0 h-96 w-96 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>What We Do</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl">
                Every programme, grouped by purpose.
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                From think sessions to public demonstrations — each programme is built to meet young people where they are.
            </p>
        </x-ui.section>
    </section>

    @foreach ($grouped as $group)
        <x-ui.section class="hairline-t">
            <x-ui.section-header :eyebrow="$group['category']->label()">
                {{ $group['programs']->count() }} {{ Str::plural('programme', $group['programs']->count()) }}
            </x-ui.section-header>

            <div class="mt-8 hairline-t">
                @foreach ($group['programs'] as $program)
                    <div class="grid gap-2 py-6 hairline-b sm:grid-cols-[1fr_2fr] sm:gap-8">
                        <p class="font-medium text-cream">{{ $program->title }}</p>
                        <p class="text-sm leading-relaxed text-muted">{{ $program->description }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endforeach

    <section class="hairline-t py-20 text-center">
        <p class="text-balance font-serif text-3xl text-cream">Want a programme running at your school?</p>
        <div class="mt-8">
            <x-ui.button href="{{ route('get-involved') }}" size="lg">Get Involved</x-ui.button>
        </div>
    </section>
</x-layouts.app>

<x-layouts.app :title="$content['what_we_do_hero_eyebrow'] ?? __('What We Do')">
    <x-ui.page-hero :eyebrow="$content['what_we_do_hero_eyebrow'] ?? __('What We Do')" :subtext="$content['what_we_do_hero_subtext'] ?? __('From think sessions to public demonstrations — each programme is built to meet young people where they are.')">
        {{ $content['what_we_do_hero_heading'] ?? __('Every programme, grouped by purpose.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    {{-- Milestone — the forum's first big goal, with its own admin-managed
         image slideshow on the left (Admin → What We Do Slideshow). All copy
         is editable under Admin → Pages → What We Do. --}}
    @if (! empty($content['what_we_do_milestone_heading']))
        <x-ui.section data-what-we-do-milestone class="section-divider" width="wide" triangles="bottom-left">
            <div @class(['grid items-center gap-12', 'lg:grid-cols-2' => $slideshowImages->isNotEmpty()])>
                @if ($slideshowImages->isNotEmpty())
                    <x-ui.crossfade-slideshow :images="$slideshowImages" />
                @endif

                <div>
                    <x-ui.section-header wide :eyebrow="$content['what_we_do_milestone_eyebrow'] ?? null">{{ $content['what_we_do_milestone_heading'] }}</x-ui.section-header>

                    @foreach ([1, 2] as $i)
                        @if (! empty($content['what_we_do_milestone_paragraph_'.$i]))
                            <x-ui.lead wide class="mt-6">{{ $content['what_we_do_milestone_paragraph_'.$i] }}</x-ui.lead>
                        @endif
                    @endforeach
                </div>
            </div>
        </x-ui.section>
    @endif

    @foreach ($grouped as $group)
        <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
            <x-ui.section-header :eyebrow="$group['category']->label()">
                {{ trans_choice(':count programme|:count programmes', $group['programs']->count(), ['count' => $group['programs']->count()]) }}
            </x-ui.section-header>

            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($group['programs'] as $program)
                    <div class="glass-row row-hover grid gap-2 py-6 pl-5 hairline-b sm:grid-cols-[1fr_2fr] sm:gap-8">
                        <p class="font-medium text-fg">{{ $program->title }}</p>
                        <p class="max-w-2xl text-sm leading-relaxed text-muted">{{ $program->description }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endforeach

    <x-ui.closing-cta />
</x-layouts.app>

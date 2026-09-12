<x-layouts.app>
    {{-- Hero --}}
    <section class="relative overflow-hidden pt-20 pb-24 sm:pt-28 sm:pb-32">
        <x-ui.glow tone="primary" class="-top-24 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 opacity-60" />
        <x-ui.glow tone="tertiary" class="top-40 -right-32 h-96 w-96 opacity-40" />

        <div class="hero-enter relative mx-auto grid w-full max-w-[120rem] gap-16 px-6 sm:px-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div class="max-w-2xl">
                <x-ui.eyebrow icon>{{ $hero['hero_eyebrow'] ?? __('South African Tobacco-Free Youth Forum') }}</x-ui.eyebrow>

                <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl lg:text-7xl">
                    {{ $hero['hero_heading'] ?? __('Speak up. Stand out.') }}
                    <span class="block text-primary-soft">{{ $hero['hero_heading_accent'] ?? __('A smoke-free generation.') }}</span>
                </h1>

                <p class="mt-6 max-w-lg text-balance text-base leading-relaxed text-muted sm:text-lg">
                    {{ $hero['hero_subtext'] ?? '' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
                    <x-ui.button href="{{ route('who-we-are') }}" variant="secondary" size="lg">{{ __('Who We Are') }}</x-ui.button>
                </div>

                <p class="mt-6 text-sm text-faint">{{ __('Youth-led') }} &middot; {{ __('No membership fee') }} &middot; {{ __('Open to every school and community') }}</p>
            </div>

            <div class="relative mx-auto flex aspect-square w-full max-w-sm items-center justify-center">
                <svg viewBox="0 0 200 200" class="h-full w-full -rotate-90">
                    <circle cx="100" cy="100" r="88" fill="none" stroke="var(--color-hairline)" stroke-width="1" />
                    <circle
                        cx="100" cy="100" r="88" fill="none" stroke="url(#vision-ring)" stroke-width="2"
                        stroke-linecap="round" stroke-dasharray="374" stroke-dashoffset="90"
                    />
                    <defs>
                        <linearGradient id="vision-ring" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#007a4d" />
                            <stop offset="33%" stop-color="#ffb612" />
                            <stop offset="66%" stop-color="#de3831" />
                            <stop offset="100%" stop-color="#002395" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-10 flex flex-col items-center justify-center rounded-full border border-hairline bg-surface/70 text-center">
                    <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="" class="brand-mark h-16 w-16 rounded-full object-cover" />
                    <p class="mt-4 font-serif text-4xl text-secondary">2030</p>
                    <p class="text-xs tracking-[0.14em] text-muted uppercase">{{ __('Our Vision') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Why we exist --}}
    <x-ui.section class="hairline-t">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr]">
            <x-ui.section-header eyebrow="{{ __('Why We Exist') }}">
                {{ $mission['mission_tagline'] ?? __('We speak and spread the truth about smoking.') }}
            </x-ui.section-header>

            <div class="space-y-7 text-balance text-base leading-relaxed text-muted sm:text-lg">
                <p class="max-w-3xl">{{ $mission['mission_statement'] ?? '' }}</p>
                <ul class="reveal-stagger grid gap-4 sm:grid-cols-3">
                    <li class="hover-lift rounded-xl border border-hairline p-5 text-sm text-fg">{{ $mission['vision_2030_1'] ?? '' }}</li>
                    <li class="hover-lift rounded-xl border border-hairline p-5 text-sm text-fg">{{ $mission['vision_2030_2'] ?? '' }}</li>
                    <li class="hover-lift rounded-xl border border-hairline p-5 text-sm text-fg">{{ $mission['vision_2030_3'] ?? '' }}</li>
                </ul>
            </div>
        </div>
    </x-ui.section>

    {{-- What we do --}}
    <x-ui.section class="hairline-t">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-ui.section-header eyebrow="{{ __('Our Programmes') }}">
                {{ __('Built around what young people need.') }}
            </x-ui.section-header>
            <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">{{ __('See everything we do') }}</x-ui.button>
        </div>

        <div class="reveal-stagger mt-10 hairline-t">
            @foreach ($programs as $category => $items)
                @php($categoryLabel = $items->first()->category->label())
                <a href="{{ route('what-we-do') }}" class="group flex items-center justify-between gap-6 py-5 hairline-b">
                    <div>
                        <p class="font-medium text-fg">{{ $categoryLabel }}</p>
                        <p class="mt-1 text-sm text-muted">{{ $items->pluck('title')->join(', ') }}</p>
                    </div>
                    <span class="shrink-0 text-muted transition-transform group-hover:translate-x-1 group-hover:text-primary-soft">&rarr;</span>
                </a>
            @endforeach
        </div>
    </x-ui.section>

    {{-- Why SATFYF is different --}}
    <x-ui.section class="hairline-t" width="narrow">
        <x-ui.section-header eyebrow="{{ __('Why It Matters') }}">{{ __('More than awareness.') }}</x-ui.section-header>

        <x-ui.tabs class="mt-10" :tabs="[
            ['label' => __('Youth-led'), 'body' => __('Every campaign, think session and demonstration is planned and led by young people themselves — not adults speaking on their behalf.')],
            ['label' => __('Evidence-based'), 'body' => __('Our messaging is grounded in real research on tobacco harm, nicotine addiction and youth marketing tactics — not scare tactics.')],
            ['label' => __('Community-rooted'), 'body' => __('Community Imbizos bring parents, teachers and local leaders into the conversation, because tobacco-free choices are made together.')],
            ['label' => __('Free to join'), 'body' => __('There is no membership fee. Any young person, school or community group can join a Think Session or start a chapter.')],
        ]" />
    </x-ui.section>

    {{-- Stats --}}
    <x-ui.section class="hairline-t">
        <div class="reveal-stagger grid grid-cols-2 gap-8 sm:grid-cols-4">
            <x-ui.stat value="2030" label="{{ __('Vision target year') }}" />
            <x-ui.stat :value="$programs->flatten()->count().'+'" label="{{ __('Active programmes') }}" />
            <x-ui.stat value="9" label="{{ __('Provinces we aim to reach') }}" />
            <x-ui.stat value="100%" label="{{ __('Youth-led') }}" />
        </div>
    </x-ui.section>

    {{-- Articles + Events --}}
    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-16 lg:grid-cols-2">
            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header eyebrow="{{ __('Latest') }}">{{ __('Articles') }}</x-ui.section-header>
                    <a href="{{ route('articles.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
                </div>

                <div class="reveal-stagger mt-8 space-y-6">
                    @forelse ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group block hairline-b pb-6">
                            <p class="text-xs text-faint">{{ $article->published_at->translatedFormat('d M Y') }}</p>
                            <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $article->title }}</p>
                            <p class="mt-1 text-sm text-muted">{{ $article->excerpt }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-muted">{{ __('Articles are coming soon.') }}</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header eyebrow="{{ __('Upcoming') }}">{{ __('Events') }}</x-ui.section-header>
                    <a href="{{ route('events.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
                </div>

                <div class="reveal-stagger mt-8 space-y-6">
                    @forelse ($events as $event)
                        <a href="{{ route('events.show', $event) }}" class="group block hairline-b pb-6">
                            <p class="text-xs text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }} &middot; {{ $event->location }}</p>
                            <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $event->title }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-muted">{{ __('No upcoming events right now — check back soon.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-ui.section>

    {{-- Partners --}}
    @if ($partners->isNotEmpty())
        <section class="hairline-t py-24 sm:py-32">
            <p class="text-center text-xs tracking-[0.14em] text-faint uppercase">{{ __('Partners & Collaborative') }}</p>
            <div class="relative mt-10 overflow-hidden [-webkit-mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)] [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                <div class="marquee-track flex w-max items-center gap-16">
                    @for ($set = 0; $set < 2; $set++)
                        @foreach ($partners as $partner)
                            <span class="shrink-0 text-sm whitespace-nowrap text-muted">{{ $partner->name }}</span>
                        @endforeach
                    @endfor
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if ($galleryImages->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-ui.section-header eyebrow="{{ __('In The Field') }}">{{ __('SATFYF, in pictures.') }}</x-ui.section-header>
                <div class="flex items-center gap-2">
                    <button type="button" data-slider-prev aria-label="{{ __('Previous images') }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-hairline-strong text-fg transition-colors hover:bg-surface">
                        <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M12 5l-6 5 6 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" data-slider-next aria-label="{{ __('Next images') }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-hairline-strong text-fg transition-colors hover:bg-surface">
                        <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M8 5l6 5-6 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </div>

            <div data-slider class="mt-10">
                <div data-slider-track class="reveal-stagger flex snap-x snap-mandatory gap-5 overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    @foreach ($galleryImages as $image)
                        <a
                            href="{{ route('gallery') }}"
                            class="hover-zoom group relative aspect-4/5 w-64 shrink-0 snap-start overflow-hidden rounded-2xl border border-hairline sm:w-72"
                        >
                            <img
                                src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                                alt="{{ $image->caption }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            />
                            @if ($image->caption)
                                <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/90 to-transparent px-4 py-4 text-sm text-fg opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    {{ $image->caption }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </x-ui.section>
    @endif

    {{-- FAQ --}}
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

    {{-- Closing CTA --}}
    <section class="relative hairline-t py-24 text-center">
        <x-ui.glow tone="primary" class="top-0 left-1/2 h-80 w-80 -translate-x-1/2 opacity-50" />
        <div class="relative mx-auto max-w-xl px-6">
            <h2 class="text-balance font-serif text-4xl text-fg sm:text-5xl">
                {{ $hero['hero_heading'] ?? __('Speak up. Stand out.') }}
                <span class="text-primary-soft">{{ $hero['hero_heading_accent'] ?? __('A smoke-free generation.') }}</span>
            </h2>
            <div class="mt-8 flex justify-center">
                <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
            </div>
            <p class="mt-4 text-sm text-faint">{{ __('No membership fee. Open to every school and community.') }}</p>
        </div>
    </section>
</x-layouts.app>

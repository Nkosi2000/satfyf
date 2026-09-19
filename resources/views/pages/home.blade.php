<x-layouts.app>
    {{-- Hero --}}
    <section class="relative overflow-hidden pt-16 pb-20 sm:pt-20 sm:pb-28">
        <div class="hero-enter relative mx-auto grid w-full max-w-[120rem] gap-10 px-6 sm:px-8 lg:grid-cols-[1.3fr_0.7fr] lg:items-center">
            <div>
                <x-ui.eyebrow>{{ $hero['hero_eyebrow'] ?? __('South African Tobacco-Free Youth Forum') }}</x-ui.eyebrow>

                <h1 class="mt-6 text-balance text-5xl leading-[0.95] font-black tracking-tight sm:text-7xl lg:text-8xl">
                    <x-ui.rainbow-heading
                        :line1="$hero['hero_heading'] ?? __('Speak up. Stand out.')"
                        :line2="$hero['hero_heading_accent'] ?? __('A smoke-free generation.')"
                    />
                </h1>

                <p class="mt-7 max-w-2xl text-balance text-lg leading-relaxed text-muted sm:text-xl">
                    {{ $hero['hero_subtext'] ?? '' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
                    <x-ui.button href="{{ route('who-we-are') }}" variant="secondary" size="lg">{{ __('Who We Are') }}</x-ui.button>
                </div>

                <p class="mt-6 text-sm font-bold text-faint">{{ __('Youth-led') }} &middot; {{ __('No membership fee') }} &middot; {{ __('Open to every school and community') }}</p>
            </div>

            {{-- A spinning coin rather than a static seal — the vision-year
                 face and a larger logo face trade places as it turns. See
                 .coin-wrap/.coin/.coin-face in app.css for the 3D mechanics. --}}
            <div class="coin-wrap relative mx-auto flex aspect-square w-full max-w-xs items-center justify-center sm:max-w-sm">
                <div class="coin relative h-full w-full">
                    <div class="coin-face flex h-full w-full flex-col items-center justify-center rounded-full border-[3px] border-fg bg-primary text-center shadow-[10px_10px_0_0_var(--color-fg)]">
                        <img src="{{ asset('images/48 x 48.png') }}" alt="" class="brand-mark h-14 w-14 rounded-full border-[3px] border-on-accent object-cover sm:h-16 sm:w-16" />
                        <p class="mt-4 text-5xl font-black text-on-accent sm:text-6xl">2030</p>
                        <p class="text-xs font-bold tracking-[0.14em] text-on-accent uppercase">{{ __('Our Vision') }}</p>
                    </div>
                    <div class="coin-face coin-face-back flex h-full w-full flex-col items-center justify-center rounded-full border-[3px] border-fg bg-tertiary text-center shadow-[10px_10px_0_0_var(--color-fg)]">
                        <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-24 w-24 rounded-full border-[3px] border-on-accent object-cover sm:h-28 sm:w-28" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- A loud, kinetic ticker strip — the marquee treatment used again
         further down for partners, surfaced right under the hero so the
         page announces its energy immediately. --}}
    <div class="block-ink overflow-hidden border-y-[3px] border-fg py-3" aria-hidden="true">
        <div class="marquee-track flex w-max items-center gap-10 text-sm font-black tracking-[0.08em] uppercase">
            @for ($i = 0; $i < 8; $i++)
                <span>{{ __('Speak up.') }}</span>
                <span class="text-primary-soft">&bull;</span>
                <span>{{ __('Stand out.') }}</span>
                <span class="text-secondary-soft">&bull;</span>
            @endfor
        </div>
    </div>

    {{-- Why we exist --}}
    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr]">
            <x-ui.section-header :eyebrow="__('Why We Exist')">
                {{ $mission['mission_tagline'] ?? __('We speak and spread the truth about smoking.') }}
            </x-ui.section-header>

            <div class="space-y-7 text-balance text-lg leading-relaxed text-muted sm:text-xl">
                <p class="max-w-3xl">{{ $mission['mission_statement'] ?? '' }}</p>
                <ul class="reveal-stagger grid gap-5 sm:grid-cols-3">
                    <li class="card-hard p-5 text-sm font-bold text-fg">{{ $mission['vision_2030_1'] ?? '' }}</li>
                    <li class="card-hard p-5 text-sm font-bold text-fg">{{ $mission['vision_2030_2'] ?? '' }}</li>
                    <li class="card-hard p-5 text-sm font-bold text-fg">{{ $mission['vision_2030_3'] ?? '' }}</li>
                </ul>
            </div>
        </div>
    </x-ui.section>

    {{-- What we do --}}
    <x-ui.section class="hairline-t" width="wide">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-ui.section-header :eyebrow="__('Our Programmes')">
                {{ __('Built around what young people need.') }}
            </x-ui.section-header>
            <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">{{ __('See everything we do') }}</x-ui.button>
        </div>

        <div class="reveal-stagger mt-10 hairline-t">
            @foreach ($programs as $category => $items)
                @php($categoryLabel = $items->first()->category->label())
                <a href="{{ route('what-we-do') }}" class="group glass-row row-hover flex items-center justify-between gap-6 py-5 pl-5 hairline-b">
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
    <x-ui.section class="hairline-t" width="wide">
        <div class="grid items-center gap-12 lg:grid-cols-[1fr_1fr]">
            <div>
                <x-ui.section-header :eyebrow="__('Why It Matters')">{{ __('More than awareness.') }}</x-ui.section-header>

                <x-ui.tabs class="mt-10" :tabs="[
                    ['label' => __('Youth-led'), 'body' => __('Every campaign, think session and demonstration is planned and led by young people themselves — not adults speaking on their behalf.')],
                    ['label' => __('Evidence-based'), 'body' => __('Our messaging is grounded in real research on tobacco harm, nicotine addiction and youth marketing tactics — not scare tactics.')],
                    ['label' => __('Community-rooted'), 'body' => __('Community Imbizos bring parents, teachers and local leaders into the conversation, because tobacco-free choices are made together.')],
                    ['label' => __('Free to join'), 'body' => __('There is no membership fee. Any young person, school or community group can join a Think Session or start a chapter.')],
                ]" />
            </div>

            {{-- Light/dark logo lockup swapped purely by CSS descendant
                 selector off the `.dark` class on <html> — the same manual
                 toggle every other colour on the site already keys off,
                 rather than Tailwind's dark: variant (which would read the
                 OS preference instead of the visitor's in-site choice). --}}
            <div class="mx-auto w-full max-w-2xl">
                <img
                    src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}"
                    alt="SATFYF"
                    class="w-full rounded-2xl border-[3px] border-fg shadow-[10px_10px_0_0_var(--shadow-hard-color)] [.dark_&]:hidden"
                />
                <img
                    src="{{ asset('images/250px-by-100px-SATFYF-LOGO-dark-mode.jpg') }}"
                    alt="SATFYF"
                    class="hidden w-full rounded-2xl border-[3px] border-fg shadow-[10px_10px_0_0_var(--shadow-hard-color)] [.dark_&]:block"
                />
            </div>
        </div>
    </x-ui.section>

    {{-- Stats — a full-bleed colour block for the poster rhythm; see the
         .block-primary note in app.css for why child text uses explicit
         on-accent classes (via the stat component's invert prop) rather
         than relying on inherited colour. --}}
    <section class="block-primary hairline-t border-b-[3px] border-fg py-16 sm:py-20">
        <div class="mx-auto w-full max-w-[120rem] px-6 sm:px-8">
            <div class="reveal-stagger grid grid-cols-2 gap-8 sm:grid-cols-4">
                <x-ui.stat invert value="2030" :label="__('Vision target year')" />
                <x-ui.stat invert :value="$programs->flatten()->count().'+'" :label="__('Active programmes')" />
                <x-ui.stat invert value="9" :label="__('Provinces we aim to reach')" />
                <x-ui.stat invert value="100%" :label="__('Youth-led')" />
            </div>
        </div>
    </section>

    {{-- Articles + Events --}}
    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-16 lg:grid-cols-2">
            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header :eyebrow="__('Latest')">{{ __('Articles') }}</x-ui.section-header>
                    <a href="{{ route('articles.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
                </div>

                <div class="reveal-stagger mt-8 space-y-6">
                    @forelse ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group glass-row row-hover block pb-6 pl-5 hairline-b">
                            <p class="text-xs text-faint">{{ $article->published_at->translatedFormat('d M Y') }}</p>
                            <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $article->title }}</p>
                            <p class="mt-1 text-sm text-muted">{{ $article->excerpt }}</p>
                        </a>
                    @empty
                        <x-ui.empty-state>{{ __('Articles are coming soon.') }}</x-ui.empty-state>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header :eyebrow="__('Upcoming')">{{ __('Events') }}</x-ui.section-header>
                    <a href="{{ route('events.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
                </div>

                <div class="reveal-stagger mt-8 space-y-6">
                    @forelse ($events as $event)
                        <a href="{{ route('events.show', $event) }}" class="group glass-row row-hover block pb-6 pl-5 hairline-b">
                            <p class="text-xs text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }} &middot; {{ $event->location }}</p>
                            <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $event->title }}</p>
                        </a>
                    @empty
                        <x-ui.empty-state>{{ __('No upcoming events right now — check back soon.') }}</x-ui.empty-state>
                    @endforelse
                </div>
            </div>
        </div>
    </x-ui.section>

    {{-- Partners --}}
    @if ($partners->isNotEmpty())
        <section class="hairline-t py-20 sm:py-24">
            <p class="text-center text-xs font-bold tracking-[0.14em] text-faint uppercase">{{ __('Partners & Collaborative') }}</p>
            <p class="mx-auto mt-3 max-w-xl text-balance text-center text-sm text-muted">{{ __('Schools, health organisations and community groups working alongside us to put tobacco-free choices within reach of more young people.') }}</p>
            <div class="relative mt-10 overflow-hidden border-y-[3px] border-fg py-4 [-webkit-mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)] [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                <div class="marquee-track flex w-max items-center gap-12">
                    @for ($set = 0; $set < 2; $set++)
                        @foreach ($partners as $partner)
                            <span class="shrink-0 text-lg font-black whitespace-nowrap text-fg uppercase">{{ $partner->name }}</span>
                            <span class="shrink-0 text-primary-soft">&#9670;</span>
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
                <x-ui.section-header :eyebrow="__('In The Field')">{{ __('SATFYF, in pictures.') }}</x-ui.section-header>
                <div class="flex items-center gap-2">
                    <button type="button" data-slider-prev aria-label="{{ __('Previous images') }}" class="press flex h-11 w-11 items-center justify-center rounded-full border-[3px] border-fg bg-surface text-fg shadow-[3px_3px_0_0_var(--shadow-hard-color)]">
                        <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M12 5l-6 5 6 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" data-slider-next aria-label="{{ __('Next images') }}" class="press flex h-11 w-11 items-center justify-center rounded-full border-[3px] border-fg bg-surface text-fg shadow-[3px_3px_0_0_var(--shadow-hard-color)]">
                        <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M8 5l6 5-6 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </div>

            <div data-slider class="mt-10">
                <div data-slider-track class="reveal-stagger flex snap-x snap-mandatory gap-5 overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    @foreach ($galleryImages as $image)
                        <a
                            href="{{ route('gallery') }}"
                            class="hover-zoom group relative aspect-4/5 w-64 shrink-0 snap-start overflow-hidden rounded-2xl border-[3px] border-fg shadow-[6px_6px_0_0_var(--shadow-hard-color)] sm:w-72"
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
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header>{{ __('Questions.') }}</x-ui.section-header>
            <x-ui.accordion class="reveal-stagger mt-8">
                @foreach ($faqs as $faq)
                    <x-ui.accordion-item :question="$faq->question">{{ $faq->answer }}</x-ui.accordion-item>
                @endforeach
            </x-ui.accordion>
        </x-ui.section>
    @endif

    {{-- Closing CTA --}}
    <x-ui.closing-cta />
</x-layouts.app>

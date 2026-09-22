<x-layouts.app>
    {{--
        This page intentionally diverges from the poster/hard-shadow system
        used everywhere else on the site (nav, footer, and every other
        page keep that) — a softer, quieter aesthetic scoped to the home
        page only, per explicit request. See .card-soft/.badge-soft/
        .text-gradient-accent in app.css for the tokens this introduces.
    --}}
    <div class="bg-cream">
        {{-- Hero — full-bleed brand cover image, no overlaid content. --}}
        <section class="relative overflow-hidden">
            <img
                src="{{ asset('images/SATFYF-Facebook-Cover-1280x474.jpeg') }}"
                alt="SATFYF"
                class="aspect-[1280/474] w-full object-cover"
            />
        </section>

        {{-- Why we exist — a subtly raised tint (not pure cream) breaks the
             page rhythm right after the hero, echoing the Stats section's
             later dark beat without competing with it. --}}
        <x-ui.section width="wide" class="bg-cream-raised">
            <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr]">
                <x-ui.section-header soft :eyebrow="__('Why We Exist')">
                    {{ $mission['mission_tagline'] ?? __('We speak and spread the truth about smoking.') }}
                </x-ui.section-header>

                <div class="space-y-7 text-balance text-lg leading-relaxed text-muted">
                    <p class="max-w-3xl">{{ $mission['mission_statement'] ?? '' }}</p>
                    <ul class="reveal-stagger grid gap-5 sm:grid-cols-3">
                        <li class="card-soft p-6 text-sm font-bold text-fg">{{ $mission['vision_2030_1'] ?? '' }}</li>
                        <li class="card-soft p-6 text-sm font-bold text-fg">{{ $mission['vision_2030_2'] ?? '' }}</li>
                        <li class="card-soft p-6 text-sm font-bold text-fg">{{ $mission['vision_2030_3'] ?? '' }}</li>
                    </ul>
                </div>
            </div>
        </x-ui.section>

        {{-- What we do --}}
        <x-ui.section width="wide">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-ui.section-header soft :eyebrow="__('Our Programmes')">
                    {{ __('Built around what young people need.') }}
                </x-ui.section-header>
                <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">{{ __('See everything we do') }}</x-ui.button>
            </div>

            <div class="reveal-stagger mt-10 hairline-t">
                @foreach ($programs as $category => $items)
                    <a href="{{ route('what-we-do') }}" class="group glass-row row-hover flex items-center justify-between gap-6 py-5 pl-5 hairline-b">
                        <div>
                            <p class="font-medium text-fg">{{ $items->first()->category->label() }}</p>
                            <p class="mt-1 text-sm text-muted">{{ $items->pluck('title')->join(', ') }}</p>
                        </div>
                        <span class="shrink-0 text-muted transition-transform group-hover:translate-x-1 group-hover:text-primary-soft">&rarr;</span>
                    </a>
                @endforeach
            </div>
        </x-ui.section>

        {{-- Why SATFYF is different --}}
        <x-ui.section width="wide" class="bg-cream-raised">
            <div class="grid items-center gap-12 lg:grid-cols-[1fr_1fr]">
                <div>
                    <x-ui.section-header soft :eyebrow="__('Why It Matters')">{{ __('More than awareness.') }}</x-ui.section-header>

                    {{-- Same data-tabs/data-tab-trigger/data-tab-panel hooks
                         as x-ui.tabs (tabs.js drives both identically) — just
                         a quiet tinted-pill active state instead of a
                         hard-shadow stamped thumb. --}}
                    <div class="mt-10" data-tabs>
                        <div class="inline-flex flex-wrap gap-1 rounded-full bg-surface-2 p-1" role="tablist">
                            @php
                                $whyTabs = [
                                    ['label' => __('Youth-led'), 'body' => __('Every campaign, think session and demonstration is planned and led by young people themselves, not adults speaking on their behalf.')],
                                    ['label' => __('Evidence-based'), 'body' => __('Our messaging is grounded in real research on tobacco harm, nicotine addiction and youth marketing tactics, not scare tactics.')],
                                    ['label' => __('Community-rooted'), 'body' => __('Community Imbizos bring parents, teachers and local leaders into the conversation, because tobacco-free choices are made together.')],
                                    ['label' => __('Free to join'), 'body' => __('There is no membership fee. Any young person, school or community group can join a Think Session or start a chapter.')],
                                ];
                            @endphp
                            @foreach ($whyTabs as $i => $tab)
                                <button
                                    type="button"
                                    data-tab-trigger="{{ $i }}"
                                    role="tab"
                                    aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                                    class="group relative rounded-full px-4 py-2 text-sm font-bold text-muted transition-colors duration-200 aria-selected:text-fg"
                                >
                                    <span class="absolute inset-0 scale-90 rounded-full bg-cream opacity-0 transition-[opacity,transform] duration-200 ease-out-strong group-aria-selected:scale-100 group-aria-selected:opacity-100" style="box-shadow: var(--shadow-soft-sm)"></span>
                                    <span class="relative">{{ $tab['label'] }}</span>
                                </button>
                            @endforeach
                        </div>

                        @foreach ($whyTabs as $i => $tab)
                            <div data-tab-panel="{{ $i }}" class="pt-8" @if ($i !== 0) hidden @endif>
                                <p class="max-w-xl text-balance text-lg leading-relaxed text-muted">{{ $tab['body'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Light/dark logo lockup, same toggle-driven swap as
                     before, restyled into a soft rounded frame. --}}
                <div class="mx-auto w-full max-w-2xl">
                    <img
                        src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}"
                        alt="SATFYF"
                        class="w-full rounded-[2rem] [.dark_&]:hidden"
                        style="box-shadow: var(--shadow-soft)"
                    />
                    <img
                        src="{{ asset('images/250px-by-100px-SATFYF-LOGO-dark-mode.jpg') }}"
                        alt="SATFYF"
                        class="hidden w-full rounded-[2rem] [.dark_&]:block"
                        style="box-shadow: var(--shadow-soft)"
                    />
                </div>
            </div>
        </x-ui.section>

        {{-- Stats — the one deliberately-dark section, mirroring the
             reference's dark gradient-glow blocks. Fixed dark regardless of
             site theme (not a theme-relative inversion like .block-ink):
             the point is a consistent moody contrast beat in the page
             rhythm, not "whichever colour opposes the current toggle". --}}
        <section class="relative overflow-hidden py-20 sm:py-24" style="background-color: #14120f">
            <div
                class="pointer-events-none absolute inset-0"
                style="background-image: radial-gradient(ellipse 60% 50% at 20% 30%, color-mix(in oklab, var(--color-primary) 35%, transparent), transparent), radial-gradient(ellipse 50% 50% at 85% 70%, color-mix(in oklab, var(--color-secondary-soft) 25%, transparent), transparent)"
                aria-hidden="true"
            ></div>
            {{-- Vertical spotlight variant — near-still beams pulsing from
                 above, reading as stage lighting behind the numbers rather
                 than the hero's faster diagonal sweep. --}}
            <x-ui.light-rays variant="vertical" class="opacity-90" />
            <div class="relative mx-auto w-full max-w-[110rem] px-6 sm:px-8">
                <div class="reveal-stagger grid grid-cols-2 gap-8 sm:grid-cols-4">
                    <x-ui.stat invert value="2030" :label="__('Vision target year')" />
                    <x-ui.stat invert :value="$programs->flatten()->count().'+'" :label="__('Active programmes')" />
                    <x-ui.stat invert value="9" :label="__('Provinces we aim to reach')" />
                    <x-ui.stat invert value="100%" :label="__('Youth-led')" />
                </div>
            </div>
        </section>

        {{-- Testimonials --}}
        @if ($testimonials->isNotEmpty())
            <x-ui.section width="wide" class="bg-cream-raised">
                <x-ui.section-header soft>{{ __('What people are saying.') }}</x-ui.section-header>

                <div class="reveal-stagger mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <figure class="card-soft flex flex-col gap-5 p-7">
                            <span class="text-5xl leading-none font-black text-primary-soft" aria-hidden="true">&ldquo;</span>
                            <blockquote class="flex-1 text-balance text-fg">{{ $testimonial->quote }}</blockquote>
                            <figcaption class="flex items-center gap-3 border-t border-hairline pt-4">
                                @if ($testimonial->photo_path)
                                    <img src="{{ storage_url($testimonial->photo_path) }}" alt="" class="h-11 w-11 shrink-0 rounded-full object-cover" />
                                @else
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-surface-2 text-sm font-black text-fg">
                                        {{ \Illuminate\Support\Str::of($testimonial->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}
                                    </span>
                                @endif
                                <div>
                                    <p class="font-black text-fg">{{ $testimonial->name }}</p>
                                    @if ($testimonial->role)
                                        <p class="text-xs font-bold text-muted uppercase">{{ $testimonial->role }}</p>
                                    @endif
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </x-ui.section>
        @endif

        {{-- Articles + Events --}}
        <x-ui.section width="wide">
            <div class="grid gap-16 lg:grid-cols-2">
                <div>
                    <div class="flex items-end justify-between gap-4">
                        <x-ui.section-header soft :eyebrow="__('Latest')">{{ __('Articles') }}</x-ui.section-header>
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
                        <x-ui.section-header soft :eyebrow="__('Upcoming')">{{ __('Events') }}</x-ui.section-header>
                        <a href="{{ route('events.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
                    </div>

                    <div class="reveal-stagger mt-8 space-y-6">
                        @forelse ($events as $event)
                            <a href="{{ route('events.show', $event) }}" class="group glass-row row-hover block pb-6 pl-5 hairline-b">
                                <p class="text-xs text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }} &middot; {{ $event->location }}</p>
                                <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $event->title }}</p>
                            </a>
                        @empty
                            <x-ui.empty-state>{{ __('No upcoming events right now. Check back soon.') }}</x-ui.empty-state>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-ui.section>

        {{-- Partners — logos only, a continuous marquee instead of a
             static wrapped strip. .marquee-track (app.css) drives the
             loop: pauses on hover, pauses in a backgrounded tab, and
             drops to a static layout under prefers-reduced-motion.
             translateX(-50%) only loops seamlessly with no visible gap
             if a single lap is already at least as wide as the widest
             realistic viewport — with a short partner list one lap is
             far narrower than that, so the track repeats the list 8x
             (not just twice) to guarantee coverage on any screen. Every
             lap past the first is aria-hidden/untabbable so screen
             readers and keyboard nav only see the list once. Each logo
             links out to the partner's own site when one is on file; a
             partner with no logo on record is skipped here rather than
             falling back to its name. --}}
        @php
            // storage_url() signs a temporary S3 URL per call, not a cheap
            // string op — compute it once per partner here rather than once
            // per rendered <img>, since the marquee repeats each partner
            // across 8 laps (40 <img> tags for 5 partners otherwise).
            $partnerLogos = $partners
                ->filter(fn ($partner) => $partner->logo_path)
                ->map(fn ($partner) => [
                    'name' => $partner->name,
                    'url' => $partner->url,
                    'logo_url' => storage_url($partner->logo_path),
                ]);
        @endphp
        @if ($partnerLogos->isNotEmpty())
            <section class="overflow-hidden bg-cream-raised py-20 sm:py-24">
                <div class="mx-auto w-full max-w-[110rem] px-6 sm:px-8">
                    <p class="text-center text-xs font-bold tracking-[0.14em] text-faint uppercase">{{ __('Trusted by') }}</p>
                </div>

                <div class="mt-10" style="mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent)">
                    {{-- Each logo sits in a fixed-size slot (flex + centered)
                         rather than sized to its own image, so slots line up
                         evenly regardless of how each partner's logo is
                         cropped. --}}
                    {{-- .marquee-track's 28s duration (app.css) is tuned for
                         its usual 2-lap case, where one animation cycle
                         (translateX 0 -> -50%) covers exactly 1 lap-width.
                         With 8 laps here, -50% covers 4 lap-widths instead
                         of 1, so the duration is scaled 4x (28s * 4 = 112s)
                         to keep the same scroll speed rather than running
                         four times faster. --}}
                    <div class="marquee-track flex w-max items-center gap-x-12" style="animation-duration: 112s">
                        @for ($lap = 0; $lap < 8; $lap++)
                            @foreach ($partnerLogos as $partner)
                                @if ($partner['url'])
                                    <a
                                        href="{{ $partner['url'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex h-20 w-44 shrink-0 items-center justify-center opacity-70 grayscale transition hover:opacity-100 hover:grayscale-0"
                                        @if ($lap > 0) aria-hidden="true" tabindex="-1" @endif
                                    >
                                        <img src="{{ $partner['logo_url'] }}" alt="{{ $partner['name'] }}" loading="lazy" class="max-h-20 max-w-full object-contain" />
                                    </a>
                                @else
                                    <span
                                        class="flex h-20 w-44 shrink-0 items-center justify-center opacity-70 grayscale transition hover:opacity-100 hover:grayscale-0"
                                        @if ($lap > 0) aria-hidden="true" @endif
                                    >
                                        <img src="{{ $partner['logo_url'] }}" alt="{{ $partner['name'] }}" loading="lazy" class="max-h-20 max-w-full object-contain" />
                                    </span>
                                @endif
                            @endforeach
                        @endfor
                    </div>
                </div>
            </section>
        @endif

        {{-- Gallery --}}
        @if ($galleryImages->isNotEmpty())
            <x-ui.section width="wide">
                <div data-slider>
                    <div class="flex flex-wrap items-end justify-between gap-6">
                        <x-ui.section-header soft>{{ __('SATFYF, in pictures.') }}</x-ui.section-header>
                        <div class="flex items-center gap-2">
                            <button type="button" data-slider-prev aria-label="{{ __('Previous images') }}" class="press flex h-11 w-11 items-center justify-center rounded-full bg-surface text-fg" style="box-shadow: var(--shadow-soft-sm)">
                                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M12 5l-6 5 6 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </button>
                            <button type="button" data-slider-next aria-label="{{ __('Next images') }}" class="press flex h-11 w-11 items-center justify-center rounded-full bg-surface text-fg" style="box-shadow: var(--shadow-soft-sm)">
                                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M8 5l6 5-6 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-10">
                        <div data-slider-track class="reveal-stagger flex snap-x snap-mandatory gap-5 overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                            @foreach ($galleryImages as $image)
                                <a
                                    href="{{ route('gallery') }}"
                                    class="hover-zoom group relative aspect-4/5 w-64 shrink-0 snap-start overflow-hidden rounded-[1.5rem] sm:w-72"
                                    style="box-shadow: var(--shadow-soft-sm)"
                                >
                                    <img
                                        src="{{ storage_url($image->image_path) }}"
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
                </div>
            </x-ui.section>
        @endif

        {{-- FAQ — same <details>/<summary> disclosure pattern as
             x-ui.accordion-item, restyled without the thick border. --}}
        @if ($faqs->isNotEmpty())
            <x-ui.section width="wide" class="bg-cream-raised">
                <x-ui.section-header soft>{{ __('Questions.') }}</x-ui.section-header>
                <div class="reveal-stagger mt-8">
                    @foreach ($faqs as $faq)
                        <details class="group border-b border-hairline py-5 last:border-b-0">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-fg marker:content-none [&::-webkit-details-marker]:hidden">
                                <span class="text-base font-bold sm:text-lg">{{ $faq->question }}</span>
                                <span class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-surface-2 text-fg transition-colors duration-200 group-open:bg-primary group-open:text-on-accent">
                                    <span class="absolute inset-0 flex items-center justify-center transition-transform duration-200 group-open:rotate-45">
                                        <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true">
                                            <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                            </summary>
                            <div class="mt-3 max-w-2xl text-sm leading-relaxed text-muted sm:text-base">
                                {{ $faq->answer }}
                            </div>
                        </details>
                    @endforeach
                </div>
            </x-ui.section>
        @endif

        {{-- Closing CTA — custom copy, same bold red block treatment as the
             shared x-ui.closing-cta every other page uses. --}}
        <section class="relative overflow-hidden px-6 py-20 sm:px-8 sm:py-28" style="background-color: var(--color-primary-deep)">
            <div
                class="pointer-events-none absolute inset-0"
                style="background-image: radial-gradient(ellipse 65% 55% at 25% 20%, color-mix(in oklab, var(--color-primary) 55%, transparent), transparent), radial-gradient(ellipse 55% 55% at 80% 85%, color-mix(in oklab, var(--color-secondary) 45%, transparent), transparent)"
                aria-hidden="true"
            ></div>
            <x-ui.light-rays class="opacity-70" />
            <div class="relative mx-auto flex w-full max-w-[110rem] flex-col items-center gap-6 text-center">
                <h2 class="font-display text-balance text-5xl leading-[1] tracking-tight text-on-accent sm:text-6xl lg:text-7xl">
                    {{ __('Ready to speak up?') }}
                </h2>
                <p class="max-w-xl text-balance text-lg leading-relaxed" style="color: color-mix(in oklab, var(--color-on-accent) 78%, transparent)">
                    {{ __('There is no membership fee, and no single way in. Start a Think Session, become a Youth Ambassador, or just tell us what you\'d like to do.') }}
                </p>
                <x-ui.button href="{{ route('get-involved') }}" variant="invert" size="lg" class="mt-2" magnetic>{{ __('Get Involved') }}</x-ui.button>
            </div>
        </section>
    </div>
</x-layouts.app>

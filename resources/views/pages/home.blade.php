<x-layouts.app>
    {{-- Hero --}}
    <section class="relative overflow-hidden pt-20 pb-24 sm:pt-28 sm:pb-32">
        <x-ui.glow tone="ember" class="-top-24 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 opacity-60" />
        <x-ui.glow tone="signal" class="top-40 -right-32 h-96 w-96 opacity-40" />

        <div class="relative mx-auto grid max-w-7xl gap-16 px-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <x-ui.eyebrow icon>{{ $hero['hero_eyebrow'] ?? 'South African Tobacco-Free Youth Forum' }}</x-ui.eyebrow>

                <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl lg:text-7xl">
                    {{ $hero['hero_heading'] ?? 'Speak up. Stand out.' }}
                    <span class="block text-ember-soft">{{ $hero['hero_heading_accent'] ?? 'A smoke-free generation.' }}</span>
                </h1>

                <p class="mt-6 max-w-lg text-balance text-base leading-relaxed text-muted sm:text-lg">
                    {{ $hero['hero_subtext'] ?? '' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <x-ui.button href="{{ route('get-involved') }}" size="lg">Get Involved</x-ui.button>
                    <x-ui.button href="{{ route('who-we-are') }}" variant="secondary" size="lg">Who We Are</x-ui.button>
                </div>

                <p class="mt-6 text-sm text-faint">Youth-led &middot; No membership fee &middot; Open to every school and community</p>
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
                            <stop offset="0%" stop-color="var(--color-ember)" />
                            <stop offset="100%" stop-color="var(--color-signal)" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-10 flex flex-col items-center justify-center rounded-full border border-hairline bg-surface/70 text-center">
                    <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="" class="h-14 w-14 rounded-full object-cover" />
                    <p class="mt-4 font-serif text-4xl text-cream">2030</p>
                    <p class="text-xs tracking-[0.14em] text-muted uppercase">Our Vision</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Why we exist --}}
    <x-ui.section class="hairline-t">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr]">
            <x-ui.section-header eyebrow="Why We Exist">
                {{ $mission['mission_tagline'] ?? 'We speak and spread the truth about smoking.' }}
            </x-ui.section-header>

            <div class="space-y-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                <p>{{ $mission['mission_statement'] ?? '' }}</p>
                <ul class="grid gap-3 sm:grid-cols-3">
                    <li class="rounded-xl border border-hairline p-4 text-sm text-cream">{{ $mission['vision_2030_1'] ?? '' }}</li>
                    <li class="rounded-xl border border-hairline p-4 text-sm text-cream">{{ $mission['vision_2030_2'] ?? '' }}</li>
                    <li class="rounded-xl border border-hairline p-4 text-sm text-cream">{{ $mission['vision_2030_3'] ?? '' }}</li>
                </ul>
            </div>
        </div>
    </x-ui.section>

    {{-- What we do --}}
    <x-ui.section class="hairline-t">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-ui.section-header eyebrow="Our Programmes">
                Built around what young people need.
            </x-ui.section-header>
            <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">See everything we do</x-ui.button>
        </div>

        <div class="mt-10 hairline-t">
            @foreach ($programs as $category => $items)
                @php($categoryLabel = $items->first()->category->label())
                <a href="{{ route('what-we-do') }}" class="group flex items-center justify-between gap-6 py-5 hairline-b">
                    <div>
                        <p class="font-medium text-cream">{{ $categoryLabel }}</p>
                        <p class="mt-1 text-sm text-muted">{{ $items->pluck('title')->join(', ') }}</p>
                    </div>
                    <span class="shrink-0 text-muted transition-transform group-hover:translate-x-1 group-hover:text-ember-soft">&rarr;</span>
                </a>
            @endforeach
        </div>
    </x-ui.section>

    {{-- Why SATFYF is different --}}
    <x-ui.section class="hairline-t" width="narrow">
        <x-ui.section-header eyebrow="Why It Matters">More than awareness.</x-ui.section-header>

        <x-ui.tabs class="mt-10" :tabs="[
            ['label' => 'Youth-led', 'body' => 'Every campaign, think session and demonstration is planned and led by young people themselves — not adults speaking on their behalf.'],
            ['label' => 'Evidence-based', 'body' => 'Our messaging is grounded in real research on tobacco harm, nicotine addiction and youth marketing tactics — not scare tactics.'],
            ['label' => 'Community-rooted', 'body' => 'Community Imbizos bring parents, teachers and local leaders into the conversation, because tobacco-free choices are made together.'],
            ['label' => 'Free to join', 'body' => 'There is no membership fee. Any young person, school or community group can join a Think Session or start a chapter.'],
        ]" />
    </x-ui.section>

    {{-- Stats --}}
    <x-ui.section class="hairline-t">
        <div class="grid grid-cols-2 gap-8 sm:grid-cols-4">
            <x-ui.stat value="2030" label="Vision target year" />
            <x-ui.stat :value="$programs->flatten()->count().'+'" label="Active programmes" />
            <x-ui.stat value="9" label="Provinces we aim to reach" />
            <x-ui.stat value="100%" label="Youth-led" />
        </div>
    </x-ui.section>

    {{-- Articles + Events --}}
    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-16 lg:grid-cols-2">
            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header eyebrow="Latest">Articles</x-ui.section-header>
                    <a href="{{ route('articles.index') }}" class="shrink-0 text-sm text-muted hover:text-cream">View all &rarr;</a>
                </div>

                <div class="mt-8 space-y-6">
                    @forelse ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group block hairline-b pb-6">
                            <p class="text-xs text-faint">{{ $article->published_at->format('d M Y') }}</p>
                            <p class="mt-2 font-medium text-cream group-hover:text-ember-soft">{{ $article->title }}</p>
                            <p class="mt-1 text-sm text-muted">{{ $article->excerpt }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-muted">Articles are coming soon.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between gap-4">
                    <x-ui.section-header eyebrow="Upcoming">Events</x-ui.section-header>
                    <a href="{{ route('events.index') }}" class="shrink-0 text-sm text-muted hover:text-cream">View all &rarr;</a>
                </div>

                <div class="mt-8 space-y-6">
                    @forelse ($events as $event)
                        <a href="{{ route('events.show', $event) }}" class="group block hairline-b pb-6">
                            <p class="text-xs text-faint">{{ $event->starts_at->format('d M Y, H:i') }} &middot; {{ $event->location }}</p>
                            <p class="mt-2 font-medium text-cream group-hover:text-ember-soft">{{ $event->title }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-muted">No upcoming events right now &mdash; check back soon.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-ui.section>

    {{-- Partners --}}
    @if ($partners->isNotEmpty())
        <x-ui.section class="hairline-t">
            <p class="text-center text-xs tracking-[0.14em] text-faint uppercase">Partners &amp; Collaborative</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-x-10 gap-y-4">
                @foreach ($partners as $partner)
                    <span class="text-sm text-muted">{{ $partner->name }}</span>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    {{-- FAQ --}}
    @if ($faqs->isNotEmpty())
        <x-ui.section class="hairline-t" width="narrow">
            <x-ui.section-header>Questions.</x-ui.section-header>
            <x-ui.accordion class="mt-8">
                @foreach ($faqs as $faq)
                    <x-ui.accordion-item :question="$faq->question">{{ $faq->answer }}</x-ui.accordion-item>
                @endforeach
            </x-ui.accordion>
        </x-ui.section>
    @endif

    {{-- Closing CTA --}}
    <section class="relative hairline-t py-24 text-center">
        <x-ui.glow tone="ember" class="top-0 left-1/2 h-80 w-80 -translate-x-1/2 opacity-50" />
        <div class="relative mx-auto max-w-xl px-6">
            <h2 class="text-balance font-serif text-4xl text-cream sm:text-5xl">
                {{ $hero['hero_heading'] ?? 'Speak up. Stand out.' }}
                <span class="text-ember-soft">{{ $hero['hero_heading_accent'] ?? 'A smoke-free generation.' }}</span>
            </h2>
            <div class="mt-8 flex justify-center">
                <x-ui.button href="{{ route('get-involved') }}" size="lg">Get Involved</x-ui.button>
            </div>
            <p class="mt-4 text-sm text-faint">No membership fee. Open to every school and community.</p>
        </div>
    </section>
</x-layouts.app>

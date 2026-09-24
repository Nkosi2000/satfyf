<x-layouts.app :title="$content['who_we_are_hero_eyebrow'] ?? __('Who We Are')">
    <x-ui.page-hero :eyebrow="$content['who_we_are_hero_eyebrow'] ?? __('Who We Are')" :subtext="$content['who_we_are_hero_subtext'] ?? null">
        {{ $content['who_we_are_hero_heading'] ?? __('Youth voices, not youth audiences.') }}

        <x-slot:image>
            <img
                src="{{ asset('images/gallery/IMG_7468-scaled.jpeg') }}"
                alt=""
                class="aspect-4/5 w-full rounded-2xl object-cover"
                style="box-shadow: var(--shadow-soft)"
            />
        </x-slot:image>
    </x-ui.page-hero>

    @if (! empty($mission['org_motto']))
        <x-ui.section class="hairline-t" width="wide">
            <p class="text-balance text-center text-3xl font-black tracking-tight text-fg sm:text-4xl">
                &ldquo;{{ $mission['org_motto'] }}&rdquo;
            </p>
        </x-ui.section>
    @endif

    @if (! empty($content['who_we_are_goals_heading']))
        <x-ui.section class="hairline-t" width="wide">
            <div @class(['grid items-center gap-12', 'lg:grid-cols-2' => $goalImages->isNotEmpty()])>
                <div>
                    <x-ui.section-header>{{ $content['who_we_are_goals_heading'] }}</x-ui.section-header>

                    @if (! empty($content['who_we_are_goals_intro']))
                        <p class="mt-6 max-w-2xl text-balance text-lg leading-relaxed text-muted">{{ $content['who_we_are_goals_intro'] }}</p>
                    @endif

                    <ol class="reveal-stagger mt-8 flex flex-col gap-4">
                        @foreach ([1, 2, 3, 4] as $i)
                            @if (! empty($content['who_we_are_goal_'.$i]))
                                <li class="card-soft flex items-start gap-4 p-5">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-surface-2 text-sm font-black text-primary-soft">{{ $loop->iteration }}</span>
                                    <p class="pt-1.5 font-bold text-fg">{{ $content['who_we_are_goal_'.$i] }}</p>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>

                @if ($goalImages->isNotEmpty())
                    <div data-crossfade class="relative">
                        <div class="relative aspect-4/5 w-full overflow-hidden rounded-2xl" style="box-shadow: var(--shadow-soft)">
                            @foreach ($goalImages as $image)
                                <img
                                    data-crossfade-slide
                                    src="{{ storage_url($image->image_path) }}"
                                    alt="{{ $image->caption }}"
                                    @unless ($loop->first) loading="lazy" aria-hidden="true" @endunless
                                    class="absolute inset-0 h-full w-full object-cover transition-opacity duration-1000 ease-in-out {{ $loop->first ? 'opacity-100' : 'opacity-0' }}"
                                />
                            @endforeach
                        </div>

                        @if ($goalImages->count() > 1)
                            <button
                                type="button"
                                data-crossfade-toggle
                                data-play-label="{{ __('Play slideshow') }}"
                                aria-pressed="false"
                                class="group absolute right-3 bottom-3 flex h-9 w-9 items-center justify-center rounded-full bg-surface/85 text-fg backdrop-blur transition-colors hover:bg-surface"
                            >
                                <span class="sr-only">{{ __('Pause slideshow') }}</span>
                                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4 group-aria-pressed:hidden" aria-hidden="true">
                                    <path d="M7.5 5v10M12.5 5v10" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                                </svg>
                                <svg viewBox="0 0 20 20" fill="currentColor" class="hidden h-4 w-4 group-aria-pressed:block" aria-hidden="true">
                                    <path d="M6.5 4.8v10.4a.6.6 0 0 0 .9.5l8.2-5.2a.6.6 0 0 0 0-1L7.4 4.3a.6.6 0 0 0-.9.5Z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </x-ui.section>
    @endif

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="$content['who_we_are_vision_eyebrow'] ?? __('Vision 2030')">{{ $content['who_we_are_vision_heading'] ?? __('By 2030, we want to see.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-3">
            <x-ui.card>{{ $mission['vision_2030_1'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_2'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_3'] ?? '' }}</x-ui.card>
        </div>
    </x-ui.section>

    @if (! empty($youthChapters['youth_chapters_intro']))
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="$youthChapters['youth_chapters_eyebrow'] ?? __('Youth Chapters')">{{ $youthChapters['youth_chapters_heading'] ?? __('Active across the country.') }}</x-ui.section-header>
            <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted">{{ $youthChapters['youth_chapters_intro'] }}</p>
            <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([1, 2, 3, 4] as $i)
                    @if (! empty($youthChapters['youth_chapters_province_'.$i]))
                        <x-ui.card class="text-center font-black text-fg">{{ $youthChapters['youth_chapters_province_'.$i] }}</x-ui.card>
                    @endif
                @endforeach
            </div>
        </x-ui.section>
    @endif

    @if ($team->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="$content['who_we_are_team_eyebrow'] ?? __('The Team')">{{ $content['who_we_are_team_heading'] ?? __('People behind the forum.') }}</x-ui.section-header>
            <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $content['who_we_are_team_body'] ?? __('A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.') }}</p>
            <div class="reveal-stagger mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <div>
                        <div class="hover-zoom aspect-square overflow-hidden rounded-2xl border border-hairline bg-surface" style="box-shadow: var(--shadow-soft-sm)">
                            @if ($member->photo_path)
                                <img src="{{ storage_url($member->photo_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-4xl text-faint">{{ Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}</div>
                            @endif
                        </div>
                        <p class="mt-4 text-2xl font-black text-fg">{{ $member->name }}</p>
                        <p class="text-sm font-bold text-primary-soft uppercase">{{ $member->role }}</p>
                        @if ($member->bio)
                            <p class="mt-2 text-sm text-muted">{{ $member->bio }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    @if (! empty($championsNetwork['champions_network_heading']))
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.card class="mx-auto flex max-w-3xl flex-col items-center gap-6 p-10 text-center">
                <h2 class="text-balance text-3xl font-black tracking-tight text-fg sm:text-4xl">
                    {{ $championsNetwork['champions_network_heading'] }}
                </h2>
                <p class="text-balance text-lg leading-relaxed text-muted">
                    {{ $championsNetwork['champions_network_body'] ?? '' }}
                </p>
                @if (! empty($championsNetwork['champions_network_cta_url']))
                    <x-ui.button
                        href="{{ $championsNetwork['champions_network_cta_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        size="lg"
                    >
                        {{ $championsNetwork['champions_network_cta_label'] ?? __('Get Involved') }}
                    </x-ui.button>
                @endif
            </x-ui.card>
        </x-ui.section>
    @endif

    <x-ui.closing-cta />
</x-layouts.app>

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
        <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
            <p class="text-balance text-center text-3xl font-black tracking-tight text-fg sm:text-4xl">
                &ldquo;{{ $mission['org_motto'] }}&rdquo;
            </p>
        </x-ui.section>
    @endif

    @if (! empty($content['who_we_are_goals_heading']))
        <x-ui.section class="section-divider" width="wide" triangles="bottom-left">
            <div @class(['grid items-center gap-12', 'lg:grid-cols-2' => $goalImages->isNotEmpty()])>
                <div>
                    <x-ui.section-header>{{ $content['who_we_are_goals_heading'] }}</x-ui.section-header>

                    @if (! empty($content['who_we_are_goals_intro']))
                        <x-ui.lead class="mt-6">{{ $content['who_we_are_goals_intro'] }}</x-ui.lead>
                    @endif

                    <ol class="reveal-stagger mt-8 flex flex-col gap-4">
                        @foreach ([1, 2, 3, 4] as $i)
                            @if (! empty($content['who_we_are_goal_'.$i]))
                                <li class="card-soft flex items-start gap-4 p-5">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-surface-2 text-base font-black text-primary-soft">{{ $loop->iteration }}</span>
                                    <x-ui.card-text strong class="pt-1">{{ $content['who_we_are_goal_'.$i] }}</x-ui.card-text>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>

                @if ($goalImages->isNotEmpty())
                    <x-ui.crossfade-slideshow :images="$goalImages" />
                @endif
            </div>
        </x-ui.section>
    @endif

    <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
        <x-ui.section-header :eyebrow="$content['who_we_are_vision_eyebrow'] ?? __('Vision 2030')">{{ $content['who_we_are_vision_heading'] ?? __('By 2030, we want to see.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-3">
            @foreach ([1, 2, 3] as $i)
                <x-ui.card>
                    <x-ui.card-text>{{ $mission['vision_2030_'.$i] ?? '' }}</x-ui.card-text>
                </x-ui.card>
            @endforeach
        </div>
    </x-ui.section>

    @if (! empty($youthChapters['youth_chapters_intro']) || $provinces->isNotEmpty())
        <x-ui.section class="section-divider" width="wide" triangles="bottom-left">
            <x-ui.section-header wide :eyebrow="$youthChapters['youth_chapters_eyebrow'] ?? __('Youth Chapters')">{{ $youthChapters['youth_chapters_heading'] ?? __('Active across the country.') }}</x-ui.section-header>
            @if (! empty($youthChapters['youth_chapters_intro']))
                <x-ui.lead wide class="mt-4">{{ $youthChapters['youth_chapters_intro'] }}</x-ui.lead>
            @endif
            @if ($provinces->isNotEmpty())
                <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($provinces as $province)
                        <x-ui.card>
                            <x-ui.card-text strong class="text-center">{{ $province->name }}</x-ui.card-text>
                        </x-ui.card>
                    @endforeach
                </div>
            @endif
        </x-ui.section>
    @endif

    @if ($team->isNotEmpty())
        <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
            <x-ui.section-header wide :eyebrow="$content['who_we_are_team_eyebrow'] ?? __('The Team')">{{ $content['who_we_are_team_heading'] ?? __('People behind the forum.') }}</x-ui.section-header>
            <x-ui.lead wide class="mt-4">{{ $content['who_we_are_team_body'] ?? __('A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.') }}</x-ui.lead>
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
        <x-ui.section class="section-divider" width="wide" triangles="bottom-left">
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

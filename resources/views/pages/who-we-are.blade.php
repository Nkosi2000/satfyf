<x-layouts.app :title="__('Who We Are')">
    <x-ui.page-hero :eyebrow="__('Who We Are')" :subtext="$mission['mission_statement'] ?? null">
        {{ __('Youth voices, not youth audiences.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @if (! empty($mission['org_motto']))
        <x-ui.section class="hairline-t" width="wide">
            <p class="text-balance text-center text-3xl font-black tracking-tight text-fg sm:text-4xl">
                &ldquo;{{ $mission['org_motto'] }}&rdquo;
            </p>
        </x-ui.section>
    @endif

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="__('Vision 2030')">{{ __('By 2030, we want to see.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-3">
            <x-ui.card>{{ $mission['vision_2030_1'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_2'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_3'] ?? '' }}</x-ui.card>
        </div>
    </x-ui.section>

    @if ($chaptersIntro)
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="__('Youth Chapters')">{{ __('Active across the country.') }}</x-ui.section-header>
            <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted">{{ $chaptersIntro }}</p>
            <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([__('KwaZulu-Natal'), __('Western Cape'), __('Gauteng'), __('Limpopo')] as $province)
                    <x-ui.card class="text-center font-black text-fg">{{ $province }}</x-ui.card>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    @if ($team->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="__('The Team')">{{ __('People behind the forum.') }}</x-ui.section-header>
            <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ __('A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.') }}</p>
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

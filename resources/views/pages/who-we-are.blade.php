<x-layouts.app :title="__('Who We Are')">
    <x-ui.page-hero :eyebrow="__('Who We Are')" :subtext="$mission['mission_statement'] ?? null">
        {{ __('Youth voices, not youth audiences.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="__('Vision 2030')">{{ __('By 2030, we want to see.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-3">
            <x-ui.card>{{ $mission['vision_2030_1'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_2'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_3'] ?? '' }}</x-ui.card>
        </div>
    </x-ui.section>

    @if ($team->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="__('The Team')">{{ __('People behind the forum.') }}</x-ui.section-header>
            <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ __('A small, youth-led core team coordinates chapters and campaigns across the country, backed by volunteers, mentors and partner organisations who help run every Think Session, Imbizo and demonstration on the ground.') }}</p>
            <div class="reveal-stagger mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <div>
                        <div class="hover-zoom aspect-square overflow-hidden rounded-2xl border border-hairline bg-surface">
                            @if ($member->photo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-4xl text-faint">{{ Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}</div>
                            @endif
                        </div>
                        <p class="mt-4 font-medium text-fg">{{ $member->name }}</p>
                        <p class="text-sm text-muted">{{ $member->role }}</p>
                        @if ($member->bio)
                            <p class="mt-2 text-sm text-muted">{{ $member->bio }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.closing-cta />
</x-layouts.app>

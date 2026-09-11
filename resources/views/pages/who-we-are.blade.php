<x-layouts.app :title="__('Who We Are')">
    <section class="relative overflow-hidden pt-24 pb-20 sm:pt-32">
        <x-ui.glow tone="tertiary" class="-top-24 -left-24 h-96 w-96 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>{{ __('Who We Are') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">
                {{ __('Youth voices, not youth audiences.') }}
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                {{ $mission['mission_statement'] ?? '' }}
            </p>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t">
        <x-ui.section-header eyebrow="{{ __('Vision 2030') }}">{{ __('By 2030, we want to see.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-3">
            <x-ui.card>{{ $mission['vision_2030_1'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_2'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_3'] ?? '' }}</x-ui.card>
        </div>
    </x-ui.section>

    @if ($team->isNotEmpty())
        <x-ui.section class="hairline-t">
            <x-ui.section-header eyebrow="{{ __('The Team') }}">{{ __('People behind the forum.') }}</x-ui.section-header>
            <div class="reveal-stagger mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <div>
                        <div class="hover-zoom aspect-square overflow-hidden rounded-2xl border border-hairline bg-surface">
                            @if ($member->photo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center font-serif text-4xl text-faint">{{ Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}</div>
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

    <section class="hairline-t py-24 text-center sm:py-32">
        <x-ui.button href="{{ route('get-involved') }}" size="lg">{{ __('Get Involved') }}</x-ui.button>
    </section>
</x-layouts.app>

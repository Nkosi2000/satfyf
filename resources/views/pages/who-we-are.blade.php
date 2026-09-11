<x-layouts.app title="Who We Are">
    <section class="relative overflow-hidden pt-20 pb-16 sm:pt-28">
        <x-ui.glow tone="signal" class="-top-24 -left-24 h-96 w-96 opacity-40" />
        <x-ui.section class="relative" width="narrow">
            <x-ui.eyebrow>Who We Are</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl">
                Youth voices, not youth audiences.
            </h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">
                {{ $mission['mission_statement'] ?? '' }}
            </p>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t">
        <x-ui.section-header eyebrow="Vision 2030">By 2030, we want to see.</x-ui.section-header>
        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <x-ui.card>{{ $mission['vision_2030_1'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_2'] ?? '' }}</x-ui.card>
            <x-ui.card>{{ $mission['vision_2030_3'] ?? '' }}</x-ui.card>
        </div>
    </x-ui.section>

    @if ($team->isNotEmpty())
        <x-ui.section class="hairline-t">
            <x-ui.section-header eyebrow="The Team">People behind the forum.</x-ui.section-header>
            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <div>
                        <div class="aspect-square overflow-hidden rounded-2xl border border-hairline bg-surface">
                            @if ($member->photo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center font-serif text-4xl text-faint">{{ Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}</div>
                            @endif
                        </div>
                        <p class="mt-4 font-medium text-cream">{{ $member->name }}</p>
                        <p class="text-sm text-muted">{{ $member->role }}</p>
                        @if ($member->bio)
                            <p class="mt-2 text-sm text-muted">{{ $member->bio }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <section class="hairline-t py-20 text-center">
        <x-ui.button href="{{ route('get-involved') }}" size="lg">Get Involved</x-ui.button>
    </section>
</x-layouts.app>

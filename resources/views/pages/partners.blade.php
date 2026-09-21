<x-layouts.app :title="__('Partners & Collaborative')">
    <x-ui.page-hero :eyebrow="__('Partners & Collaborative')" :subtext="__('Schools, health organisations, government departments and community groups who share the venues, the credibility and the reach it takes to put tobacco-free choices in front of more young people.')">
        {{ __("We don't do this alone.") }}
    </x-ui.page-hero>

    @foreach ($types as $type)
        @if ($partners->has($type->value))
            <x-ui.section class="hairline-t" width="wide">
                <x-ui.section-header :eyebrow="$type->label()">
                    {{ trans_choice(':count organisation|:count organisations', $partners[$type->value]->count(), ['count' => $partners[$type->value]->count()]) }}
                </x-ui.section-header>
                @if ($type === App\Enums\PartnerType::AdvisoryCouncil && ! empty($partnerSettings['advisory_council_intro']))
                    <p class="mt-4 max-w-2xl text-balance text-lg leading-relaxed text-muted">{{ $partnerSettings['advisory_council_intro'] }}</p>
                @endif
                <div class="reveal-stagger mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners[$type->value] as $partner)
                        <x-ui.card class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                @if ($partner->logo_path)
                                    <img src="{{ storage_url($partner->logo_path) }}" alt="{{ $partner->name }}" loading="lazy" class="h-12 w-12 shrink-0 rounded-lg object-cover" />
                                @else
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-surface-2 text-sm font-black text-fg">
                                        {{ \Illuminate\Support\Str::of($partner->name)->explode(' ')->take(2)->map(fn ($word) => \Illuminate\Support\Str::upper($word[0]))->join('') }}
                                    </span>
                                @endif
                                <p class="font-black text-fg">{{ $partner->name }}</p>
                            </div>

                            @if ($partner->role)
                                <x-ui.pill-chip class="w-fit">{{ $partner->role }}</x-ui.pill-chip>
                            @endif

                            @if ($partner->description)
                                <p class="flex-1 text-sm leading-relaxed text-muted">{{ $partner->description }}</p>
                            @endif

                            @if ($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-primary-soft hover:underline">{{ __('Visit website') }} &rarr;</a>
                            @endif
                        </x-ui.card>
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    @endforeach
</x-layouts.app>

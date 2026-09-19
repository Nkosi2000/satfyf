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
                <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners[$type->value] as $partner)
                        <x-ui.card class="flex items-center gap-4">
                            @if ($partner->logo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="h-10 w-10 rounded-lg border-[3px] border-fg object-cover" />
                            @endif
                            <div>
                                <p class="font-black text-fg">{{ $partner->name }}</p>
                                @if ($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-muted hover:text-primary-soft">{{ __('Visit site') }} &rarr;</a>
                                @endif
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    @endforeach
</x-layouts.app>

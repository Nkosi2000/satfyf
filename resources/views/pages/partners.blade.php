<x-layouts.app :title="__('Partners & Collaborative')">
    <section class="pt-24 pb-20 sm:pt-32">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>{{ __('Partners & Collaborative') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">{{ __("We don't do this alone.") }}</h1>
        </x-ui.section>
    </section>

    @foreach ($types as $type)
        @if ($partners->has($type->value))
            <x-ui.section class="hairline-t">
                <x-ui.section-header :eyebrow="$type->label()">
                    {{ trans_choice(':count organisation|:count organisations', $partners[$type->value]->count(), ['count' => $partners[$type->value]->count()]) }}
                </x-ui.section-header>
                <div class="reveal-stagger mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners[$type->value] as $partner)
                        <x-ui.card class="flex items-center gap-4">
                            @if ($partner->logo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="h-10 w-10 rounded-lg object-cover" />
                            @endif
                            <div>
                                <p class="font-medium text-fg">{{ $partner->name }}</p>
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

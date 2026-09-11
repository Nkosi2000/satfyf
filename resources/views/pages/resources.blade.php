<x-layouts.app :title="__('Resources')">
    <section class="pt-24 pb-20 sm:pt-32">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>{{ __('Resources') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">{{ __('Facts you can hand someone.') }}</h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">{{ __('Fact sheets, toolkits and reports — free to download and share.') }}</p>
        </x-ui.section>
    </section>

    @forelse ($resources as $category => $items)
        <x-ui.section class="hairline-t">
            <x-ui.section-header :eyebrow="$category ?: __('General')">{{ trans_choice(':count file|:count files', $items->count(), ['count' => $items->count()]) }}</x-ui.section-header>
            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($items as $resource)
                    <div class="flex items-center justify-between gap-6 py-5 hairline-b">
                        <div class="max-w-2xl">
                            <p class="font-medium text-fg">{{ $resource->title }}</p>
                            @if ($resource->description)
                                <p class="mt-1 text-sm text-muted">{{ $resource->description }}</p>
                            @endif
                        </div>
                        <x-ui.button href="{{ route('resources.download', $resource) }}" variant="secondary" size="sm" class="shrink-0">{{ __('Download') }}</x-ui.button>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @empty
        <x-ui.section class="hairline-t">
            <p class="text-sm text-muted">{{ __('Resources are coming soon.') }}</p>
        </x-ui.section>
    @endforelse
</x-layouts.app>

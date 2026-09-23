<x-layouts.app :title="$content['resources_page_hero_eyebrow'] ?? __('Resources')">
    <x-ui.page-hero :eyebrow="$content['resources_page_hero_eyebrow'] ?? __('Resources')" :subtext="$content['resources_page_hero_subtext'] ?? __('Fact sheets, toolkits and reports — free to download and share.')">
        {{ $content['resources_page_hero_heading'] ?? __('Facts you can hand someone.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @forelse ($resources as $category => $items)
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="$category ?: __('General')">{{ trans_choice(':count file|:count files', $items->count(), ['count' => $items->count()]) }}</x-ui.section-header>
            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($items as $resource)
                    <div class="glass-row row-hover group flex items-center justify-between gap-6 py-5 pl-5 hairline-b">
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
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.empty-state>{{ __('Resources are coming soon.') }}</x-ui.empty-state>
        </x-ui.section>
    @endforelse
</x-layouts.app>

@use('Illuminate\Support\Str')

<x-layouts.app title="Resources">
    <section class="pt-20 pb-16 sm:pt-28">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>Resources</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl">Facts you can hand someone.</h1>
            <p class="mt-6 text-balance text-base leading-relaxed text-muted sm:text-lg">Fact sheets, toolkits and reports — free to download and share.</p>
        </x-ui.section>
    </section>

    @forelse ($resources as $category => $items)
        <x-ui.section class="hairline-t">
            <x-ui.section-header :eyebrow="$category ?: 'General'">{{ $items->count() }} {{ Str::plural('file', $items->count()) }}</x-ui.section-header>
            <div class="mt-8 hairline-t">
                @foreach ($items as $resource)
                    <div class="flex items-center justify-between gap-6 py-5 hairline-b">
                        <div>
                            <p class="font-medium text-cream">{{ $resource->title }}</p>
                            @if ($resource->description)
                                <p class="mt-1 text-sm text-muted">{{ $resource->description }}</p>
                            @endif
                        </div>
                        <x-ui.button href="{{ route('resources.download', $resource) }}" variant="secondary" size="sm" class="shrink-0">Download</x-ui.button>
                    </div>
                @endforeach
            </div>
        </x-ui.section>
    @empty
        <x-ui.section class="hairline-t">
            <p class="text-sm text-muted">Resources are coming soon.</p>
        </x-ui.section>
    @endforelse
</x-layouts.app>

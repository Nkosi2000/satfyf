<x-layouts.app :title="$content['gallery_page_hero_eyebrow'] ?? __('Gallery')">
    <x-ui.page-hero :eyebrow="$content['gallery_page_hero_eyebrow'] ?? __('Gallery')" :subtext="$content['gallery_page_hero_subtext'] ?? __('Think sessions, school visits, public demonstrations and Community Imbizos — a running record of where young people are showing up and speaking out.')">
        {{ $content['gallery_page_hero_heading'] ?? __('SATFYF, in the field.') }}

        <x-slot:image>
            @if ($images->isNotEmpty())
                <img
                    src="{{ storage_url($images->first()->image_path) }}"
                    alt="{{ $images->first()->caption }}"
                    class="aspect-4/5 w-full rounded-2xl object-cover"
                    style="box-shadow: var(--shadow-soft)"
                />
            @else
                <x-ui.brand-hero-image />
            @endif
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="reveal-stagger columns-2 gap-4 sm:columns-3">
            @foreach ($images as $image)
                {{-- Border only, no hard shadow — a whole masonry grid of
                     offset shadows reads as noise rather than poster energy;
                     the thick border alone is enough at this density. --}}
                <div class="hover-zoom mb-4 break-inside-avoid overflow-hidden rounded-xl border border-hairline">
                    <img
                        src="{{ storage_url($image->image_path) }}"
                        alt="{{ $image->caption }}"
                        loading="lazy"
                        class="w-full"
                    />
                </div>
            @endforeach
        </div>
    </x-ui.section>
</x-layouts.app>

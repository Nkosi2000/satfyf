<x-layouts.app :title="__('Gallery')">
    <x-ui.page-hero :eyebrow="__('Gallery')" :subtext="__('Think sessions, school visits, public demonstrations and Community Imbizos — a running record of where young people are showing up and speaking out.')">
        {{ __('SATFYF, in the field.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="reveal-stagger columns-2 gap-4 sm:columns-3">
            @foreach ($images as $image)
                {{-- Border only, no hard shadow — a whole masonry grid of
                     offset shadows reads as noise rather than poster energy;
                     the thick border alone is enough at this density. --}}
                <div class="hover-zoom mb-4 break-inside-avoid overflow-hidden rounded-xl border-[3px] border-fg">
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

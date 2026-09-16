<x-layouts.app :title="__('Gallery')">
    <x-ui.page-hero :eyebrow="__('Gallery')" :subtext="__('Think sessions, school visits, public demonstrations and Community Imbizos — a running record of where young people are showing up and speaking out.')">
        {{ __('SATFYF, in the field.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="reveal-stagger columns-2 gap-4 sm:columns-3">
            @foreach ($images as $image)
                <div class="hover-zoom mb-4 break-inside-avoid overflow-hidden rounded-xl border border-hairline">
                    <img
                        src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                        alt="{{ $image->caption }}"
                        loading="lazy"
                        class="w-full"
                    />
                </div>
            @endforeach
        </div>
    </x-ui.section>
</x-layouts.app>

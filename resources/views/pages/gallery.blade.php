<x-layouts.app :title="__('Gallery')">
    <section class="pt-24 pb-20 sm:pt-32">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>{{ __('Gallery') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">{{ __('SATFYF, in the field.') }}</h1>
        </x-ui.section>
    </section>

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

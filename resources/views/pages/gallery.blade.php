<x-layouts.app title="Gallery">
    <section class="pt-20 pb-16 sm:pt-28">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>Gallery</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl">SATFYF, in the field.</h1>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t" width="wide">
        <div class="columns-2 gap-4 sm:columns-3">
            @foreach ($images as $image)
                <div class="mb-4 break-inside-avoid overflow-hidden rounded-xl border border-hairline">
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

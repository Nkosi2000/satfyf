@props(['images'])

{{--
    A portrait frame that crossfades through uploaded images (see
    resources/js/modules/crossfade.js), with a pause/play toggle once
    there's more than one. Used beside text sections that have their own
    admin-managed slideshow (Who We Are goals, What We Do milestone).
--}}
<div data-crossfade {{ $attributes->class(['relative']) }}>
    <div class="relative aspect-4/5 w-full overflow-hidden rounded-2xl" style="box-shadow: var(--shadow-soft)">
        @foreach ($images as $image)
            <img
                data-crossfade-slide
                src="{{ storage_url($image->image_path) }}"
                alt="{{ $image->caption }}"
                @unless ($loop->first) loading="lazy" aria-hidden="true" @endunless
                class="absolute inset-0 h-full w-full object-cover transition-opacity duration-1000 ease-in-out {{ $loop->first ? 'opacity-100' : 'opacity-0' }}"
            />
        @endforeach
    </div>

    @if ($images->count() > 1)
        <button
            type="button"
            data-crossfade-toggle
            data-play-label="{{ __('Play slideshow') }}"
            aria-pressed="false"
            class="group absolute right-3 bottom-3 flex h-9 w-9 items-center justify-center rounded-full bg-surface/85 text-fg backdrop-blur transition-colors hover:bg-surface"
        >
            <span class="sr-only">{{ __('Pause slideshow') }}</span>
            <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4 group-aria-pressed:hidden" aria-hidden="true">
                <path d="M7.5 5v10M12.5 5v10" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
            </svg>
            <svg viewBox="0 0 20 20" fill="currentColor" class="hidden h-4 w-4 group-aria-pressed:block" aria-hidden="true">
                <path d="M6.5 4.8v10.4a.6.6 0 0 0 .9.5l8.2-5.2a.6.6 0 0 0 0-1L7.4 4.3a.6.6 0 0 0-.9.5Z" />
            </svg>
        </button>
    @endif
</div>

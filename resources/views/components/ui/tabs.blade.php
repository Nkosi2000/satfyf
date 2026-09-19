@props(['tabs'])

{{--
    A poster-style segmented control: a thick-bordered track with a solid
    green, hard-shadowed "thumb" behind whichever tab is selected — the
    active segment reads as a stamped, physical object rather than a soft
    highlight.
--}}
<div {{ $attributes }} data-tabs>
    <div class="inline-flex flex-wrap gap-1 rounded-full border-[3px] border-fg p-1" role="tablist">
        @foreach ($tabs as $i => $tab)
            <button
                type="button"
                data-tab-trigger="{{ $i }}"
                role="tab"
                aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                class="group relative rounded-full px-4 py-2 text-sm font-bold text-muted transition-colors duration-200 aria-selected:text-on-accent"
            >
                <span class="absolute inset-0 scale-90 rounded-full bg-primary opacity-0 shadow-[2px_2px_0_0_var(--color-fg)] transition-[opacity,transform] duration-200 ease-out-strong group-aria-selected:scale-100 group-aria-selected:opacity-100"></span>
                <span class="relative">{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $i => $tab)
        <div data-tab-panel="{{ $i }}" class="pt-8" @if ($i !== 0) hidden @endif>
            <p class="max-w-xl text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $tab['body'] }}</p>
        </div>
    @endforeach
</div>

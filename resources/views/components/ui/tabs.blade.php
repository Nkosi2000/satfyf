@props(['tabs'])

{{--
    A quiet segmented control: a tinted-pill track with a soft-shadowed
    "thumb" behind whichever tab is selected, instead of a stamped,
    hard-bordered object.
--}}
<div {{ $attributes }} data-tabs>
    <div class="inline-flex flex-wrap gap-1 rounded-full bg-surface-2 p-1" role="tablist">
        @foreach ($tabs as $i => $tab)
            <button
                type="button"
                data-tab-trigger="{{ $i }}"
                role="tab"
                aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                class="group relative rounded-full px-4 py-2 text-sm font-bold text-muted transition-colors duration-200 aria-selected:text-fg"
            >
                <span class="absolute inset-0 scale-90 rounded-full bg-cream opacity-0 transition-[opacity,transform] duration-200 ease-out-strong group-aria-selected:scale-100 group-aria-selected:opacity-100" style="box-shadow: var(--shadow-soft-sm)"></span>
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

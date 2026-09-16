@props(['tabs'])

<div {{ $attributes }} data-tabs>
    <div class="hairline-b flex flex-wrap gap-x-8 gap-y-3" role="tablist">
        @foreach ($tabs as $i => $tab)
            <button
                type="button"
                data-tab-trigger="{{ $i }}"
                role="tab"
                aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                class="group relative pb-4 text-sm font-medium text-muted transition-colors aria-selected:text-fg"
            >
                {{ $tab['label'] }}
                <span class="absolute inset-x-0 -bottom-px h-px scale-x-0 bg-primary-soft transition-transform duration-200 group-aria-selected:scale-x-100"></span>
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $i => $tab)
        <div data-tab-panel="{{ $i }}" class="pt-8" @if ($i !== 0) hidden @endif>
            <p class="max-w-xl text-balance text-lg leading-relaxed text-muted sm:text-xl">{{ $tab['body'] }}</p>
        </div>
    @endforeach
</div>

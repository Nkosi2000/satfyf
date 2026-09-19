<div class="relative" data-search>
    <button
        type="button"
        data-search-toggle
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="search-modal"
        {{ $attributes->class(['flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-[3px] border-fg text-fg transition-transform duration-150 ease-out hover:-translate-y-0.5 active:translate-y-0']) }}
    >
        <span class="sr-only">{{ __('Search the site') }}</span>
        <svg viewBox="0 0 20 20" fill="none" class="h-4.5 w-4.5" aria-hidden="true">
            <circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5" />
            <path d="m17 17-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
    </button>

    <div
        id="search-modal"
        data-search-modal
        hidden
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('Search') }}"
        class="fixed inset-0 z-[70] flex items-start justify-center bg-fg/40 px-6 pt-24 sm:pt-32"
    >
        <div data-search-panel class="w-full max-w-xl rounded-2xl border-[3px] border-fg bg-surface p-2 shadow-[10px_10px_0_0_var(--shadow-hard-color)]">
            <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2">
                <svg viewBox="0 0 20 20" fill="none" class="ml-3 h-5 w-5 shrink-0 text-muted" aria-hidden="true">
                    <circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5" />
                    <path d="m17 17-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                <label for="nav-search-input" class="sr-only">{{ __('Search the site') }}</label>
                <input
                    id="nav-search-input"
                    data-search-input
                    type="search"
                    name="q"
                    required
                    placeholder="{{ __('Search articles, events, programmes…') }}"
                    class="w-full bg-transparent py-3 text-base font-bold text-fg placeholder:font-normal placeholder:text-faint focus:outline-none"
                />
                <x-ui.button type="submit" size="sm" class="mr-1 shrink-0">{{ __('Search') }}</x-ui.button>
            </form>
        </div>
    </div>
</div>

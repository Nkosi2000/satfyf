<x-layouts.app :title="__('Search')">
    <x-ui.page-hero :eyebrow="__('Search')">
        {{ $query !== '' ? __('Results for ":query"', ['query' => $query]) : __('Search the site.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <form action="{{ route('search') }}" method="GET" class="flex max-w-xl items-center gap-2 rounded-full border-[3px] border-fg bg-surface p-2 shadow-[6px_6px_0_0_var(--shadow-hard-color)]">
            <svg viewBox="0 0 20 20" fill="none" class="ml-2 h-5 w-5 shrink-0 text-muted" aria-hidden="true">
                <circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5" />
                <path d="m17 17-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            <label for="page-search-input" class="sr-only">{{ __('Search the site') }}</label>
            <input
                id="page-search-input"
                type="search"
                name="q"
                value="{{ $query }}"
                required
                placeholder="{{ __('Search articles, events, programmes…') }}"
                class="w-full bg-transparent py-2 text-base font-bold text-fg placeholder:font-normal placeholder:text-faint focus:outline-none"
            />
            <x-ui.button type="submit" size="sm" class="shrink-0">{{ __('Search') }}</x-ui.button>
        </form>

        @if ($query !== '')
            <div class="reveal-stagger mt-10 hairline-t">
                @forelse ($results as $result)
                    <a href="{{ $result['url'] }}" class="group glass-row row-hover flex flex-col gap-2 py-5 pl-5 hairline-b">
                        <div class="flex items-center gap-3">
                            <x-ui.pill-chip>{{ $result['type'] }}</x-ui.pill-chip>
                            <p class="font-black text-fg group-hover:text-primary-soft">{{ $result['title'] }}</p>
                        </div>
                        @if ($result['excerpt'])
                            <p class="line-clamp-2 max-w-2xl text-sm text-muted">{{ $result['excerpt'] }}</p>
                        @endif
                    </a>
                @empty
                    <x-ui.empty-state class="!py-16">
                        {{ __('No results for ":query" — try a different word.', ['query' => $query]) }}
                    </x-ui.empty-state>
                @endforelse
            </div>
        @endif
    </x-ui.section>
</x-layouts.app>

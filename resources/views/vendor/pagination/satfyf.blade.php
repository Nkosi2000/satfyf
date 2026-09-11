@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Page navigation') }}" class="flex items-center justify-between gap-4">
        @if ($paginator->onFirstPage())
            <span class="rounded-full border border-hairline px-4 py-2 text-sm text-faint">{{ __('Previous') }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-full border border-hairline-strong px-4 py-2 text-sm text-fg hover:bg-surface">{{ __('Previous') }}</a>
        @endif

        <p class="text-sm text-muted">{{ __('Page :current of :last', ['current' => $paginator->currentPage(), 'last' => $paginator->lastPage()]) }}</p>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-full border border-hairline-strong px-4 py-2 text-sm text-fg hover:bg-surface">{{ __('Next') }}</a>
        @else
            <span class="rounded-full border border-hairline px-4 py-2 text-sm text-faint">{{ __('Next') }}</span>
        @endif
    </nav>
@endif

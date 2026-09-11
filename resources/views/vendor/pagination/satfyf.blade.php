@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">
        @if ($paginator->onFirstPage())
            <span class="rounded-full border border-hairline px-4 py-2 text-sm text-faint">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-full border border-hairline-strong px-4 py-2 text-sm text-cream hover:bg-surface">Previous</a>
        @endif

        <p class="text-sm text-muted">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</p>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-full border border-hairline-strong px-4 py-2 text-sm text-cream hover:bg-surface">Next</a>
        @else
            <span class="rounded-full border border-hairline px-4 py-2 text-sm text-faint">Next</span>
        @endif
    </nav>
@endif

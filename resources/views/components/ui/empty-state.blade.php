<div {{ $attributes->class(['flex flex-col items-center gap-4 py-10 text-center']) }}>
    <span class="relative flex h-12 w-12 shrink-0 items-center justify-center">
        <span class="empty-state-ping absolute inset-0 rounded-full border border-hairline-strong"></span>
        <span class="relative flex h-12 w-12 items-center justify-center rounded-full border border-hairline-strong text-faint">
            <svg viewBox="0 0 20 20" fill="none" class="h-5 w-5" aria-hidden="true">
                <path d="M10 2.5v8M10 14.5v.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <circle cx="10" cy="10" r="7.5" stroke="currentColor" stroke-width="1.5" />
            </svg>
        </span>
    </span>
    <p class="text-sm text-muted">{{ $slot }}</p>
</div>

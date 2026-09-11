<button
    type="button"
    data-theme-toggle
    {{ $attributes->class(['flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-hairline-strong text-fg transition-colors hover:bg-surface hover:border-fg/30']) }}
>
    <span class="sr-only">{{ __('Toggle dark mode') }}</span>

    <svg data-theme-icon="dark" hidden viewBox="0 0 20 20" fill="none" class="h-4.5 w-4.5" aria-hidden="true">
        <path
            d="M17.5 10.9A7.5 7.5 0 0 1 9.1 2.5a7.5 7.5 0 1 0 8.4 8.4Z"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
        />
    </svg>

    <svg data-theme-icon="light" hidden viewBox="0 0 20 20" fill="none" class="h-4.5 w-4.5" aria-hidden="true">
        <circle cx="10" cy="10" r="3.5" stroke="currentColor" stroke-width="1.5" />
        <path
            d="M10 2.5v2M10 15.5v2M17.5 10h-2M4.5 10h-2M15.3 4.7l-1.4 1.4M6.1 13.9l-1.4 1.4M15.3 15.3l-1.4-1.4M6.1 6.1 4.7 4.7"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
        />
    </svg>
</button>

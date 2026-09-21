@props(['question', 'open' => false])

<details class="group border-b border-hairline py-5 last:border-b-0" @if ($open) open @endif>
    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-fg marker:content-none [&::-webkit-details-marker]:hidden">
        <span class="text-base font-bold sm:text-lg">{{ $question }}</span>
        <span class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-surface-2 text-fg transition-colors duration-200 group-open:bg-primary group-open:text-on-accent">
            <span class="absolute inset-0 flex items-center justify-center transition-transform duration-200 group-open:rotate-45">
                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true">
                    <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </span>
        </span>
    </summary>
    <div class="mt-3 max-w-2xl text-sm leading-relaxed text-muted sm:text-base">
        {{ $slot }}
    </div>
</details>

@props(['heading', 'open' => false, 'idPrefix'])

<button
    type="button"
    data-nav-group-toggle
    aria-expanded="{{ $open ? 'true' : 'false' }}"
    aria-controls="{{ $idPrefix }}-{{ Str::slug($heading) }}"
    {{ $attributes->class(['group flex w-full items-center justify-between rounded-lg px-3 py-1.5 text-xs font-bold tracking-wider text-faint uppercase transition-colors hover:text-fg']) }}
>
    {{ $heading }}
    <svg viewBox="0 0 20 20" fill="none" class="h-3.5 w-3.5 shrink-0 transition-transform duration-200 group-aria-expanded:rotate-180" aria-hidden="true">
        <path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</button>

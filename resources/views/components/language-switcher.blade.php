@php
    $locales = [
        'en' => 'English',
        'zu' => 'isiZulu',
        'st' => 'Sesotho',
        'af' => 'Afrikaans',
    ];
    $current = app()->getLocale();
@endphp

<div class="relative" data-lang-switcher>
    <button
        type="button"
        data-lang-toggle
        aria-haspopup="true"
        aria-expanded="false"
        aria-controls="lang-menu"
        {{ $attributes->class(['flex h-11 shrink-0 items-center gap-1.5 rounded-full bg-surface-2 px-3.5 text-sm font-bold text-fg transition-transform duration-150 ease-out hover:-translate-y-0.5 active:translate-y-0']) }}
    >
        <span class="sr-only">{{ __('Change language') }}</span>
        <span aria-hidden="true">{{ strtoupper($current) }}</span>
        <svg viewBox="0 0 20 20" fill="none" class="h-3.5 w-3.5 transition-transform duration-150 ease-out group-aria-expanded:rotate-180" aria-hidden="true">
            <path d="M5 7.5 10 12.5 15 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <div
        id="lang-menu"
        data-lang-menu
        hidden
        role="menu"
        class="absolute right-0 z-50 mt-2 w-40 origin-top-right rounded-xl border border-hairline bg-surface p-1.5"
        style="box-shadow: var(--shadow-soft)"
    >
        @foreach ($locales as $code => $label)
            <a
                href="{{ route('language.set', $code) }}"
                role="menuitemradio"
                aria-checked="{{ $current === $code ? 'true' : 'false' }}"
                class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-fg transition-colors hover:bg-surface-2"
            >
                <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border {{ $current === $code ? 'border-primary-soft' : 'border-hairline-strong' }}">
                    <span class="h-2 w-2 rounded-full bg-primary-soft {{ $current === $code ? '' : 'opacity-0' }}"></span>
                </span>
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

@php
    // Each icon fills with its own logo colour on hover, in the same
    // rotation the nav underlines use.
    $hoverColors = ['var(--color-brand-red)', 'var(--color-brand-green)', 'var(--color-brand-blue)', 'var(--color-brand-orange)'];
@endphp

{{--
    Social profiles pinned to the left edge of the screen, vertically
    centred, so they stay in reach at every scroll position. Hidden below
    md, where there's no side gutter to spare — the footer lists the same
    links there. Renders nothing when no profile URLs are set in admin.
--}}
@if (count($socials) > 0)
    <aside
        data-social-rail
        aria-label="{{ __('Follow SATFYF') }}"
        class="fixed top-1/2 left-0 z-40 hidden -translate-y-1/2 flex-col items-center gap-3 rounded-r-2xl border border-l-0 border-hairline bg-cream/90 px-2 py-4 backdrop-blur md:flex"
        style="box-shadow: var(--shadow-soft-sm)"
    >
        <span class="text-xs font-bold tracking-[0.14em] text-muted uppercase [writing-mode:vertical-rl] rotate-180">{{ __('Follow us') }}</span>
        <span class="h-6 w-px bg-hairline-strong" aria-hidden="true"></span>

        @foreach ($socials as $social)
            <a
                href="{{ $social['url'] }}"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="{{ $social['label'] }}"
                title="{{ $social['label'] }}"
                class="flex h-10 w-10 items-center justify-center rounded-full text-fg transition-[background-color,color,transform] duration-200 ease-out hover:scale-110 hover:bg-(--social-hover) hover:text-on-accent focus-visible:bg-(--social-hover) focus-visible:text-on-accent"
                style="--social-hover: {{ $hoverColors[$loop->index % count($hoverColors)] }}"
            >
                <x-icon.social :name="$social['icon']" class="h-4 w-4" />
            </a>
        @endforeach
    </aside>
@endif

@php
    // Every link shares one quiet accent underline now — the old per-link
    // rainbow rotation was a poster-system flourish that reads as noisy
    // chrome against the site's restrained soft palette.
    $links = [
        ['label' => __('Home'), 'route' => 'home'],
        ['label' => __('Who We Are'), 'route' => 'who-we-are'],
        ['label' => __('Why We Exist'), 'route' => 'why-we-exist'],
        ['label' => __('What We Do'), 'route' => 'what-we-do'],
        ['label' => __('Articles'), 'route' => 'articles.index'],
        ['label' => __('Events'), 'route' => 'events.index'],
    ];

    $moreLinks = [
        ['label' => __('Resources'), 'route' => 'resources.index'],
        ['label' => __('Gallery'), 'route' => 'gallery'],
        ['label' => __('Partners'), 'route' => 'partners'],
        ['label' => __('Contact Us'), 'route' => 'contact'],
    ];
@endphp

{{--
    A full-width banner bar, pinned to the top of the viewport, with a
    quiet hairline edge and a translucent backdrop-blur ground instead of
    the old poster system's thick flag border.
--}}
<header data-site-header class="sticky inset-x-0 top-0 z-50 border-b border-hairline bg-cream/85 backdrop-blur">
    {{-- max-width is a literal px value, not rem — the site's html { font-size:
         65% } scales every rem-based size down (by design, for page content),
         but that would also silently shrink this cap to ~1248px regardless of
         viewport width, starving the nav of room and wrapping link labels. --}}
    <div class="mx-auto flex w-full max-w-[1800px] items-center justify-between gap-8 px-6 py-3 sm:px-8">
        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2">
                <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-12 w-12 rounded-full object-cover sm:h-14 sm:w-14" style="box-shadow: var(--shadow-soft-sm)" />
            </a>

            <nav class="hidden items-center gap-8 min-[1450px]:flex" aria-label="Primary">
                @foreach ($links as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="group relative py-1 text-base font-bold text-muted transition-colors hover:text-fg {{ request()->routeIs($link['route']) ? 'text-fg' : '' }}"
                    >
                        {{ $link['label'] }}
                        <span class="absolute inset-x-0 -bottom-0.5 h-px origin-left scale-x-0 bg-primary-soft transition-transform duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="hidden items-center gap-6 min-[1450px]:flex">
            @foreach ($moreLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="group relative py-1 text-base font-bold text-muted transition-colors hover:text-fg {{ request()->routeIs($link['route']) ? 'text-fg' : '' }}"
                >
                    {{ $link['label'] }}
                    <span class="absolute inset-x-0 -bottom-0.5 h-px origin-left scale-x-0 bg-primary-soft transition-transform duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                </a>
            @endforeach
            <x-ui.button href="{{ route('get-involved') }}" size="sm">{{ __('Get Involved') }}</x-ui.button>
            <x-search-trigger />
            <x-language-switcher />
            <x-theme-toggle />
        </div>

        <div class="flex items-center gap-3 min-[1450px]:hidden">
            <x-search-trigger />
            <x-language-switcher />
            <x-theme-toggle />

            <button
                type="button"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="mobile-nav"
                class="group flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-surface-2 text-fg transition-colors"
            >
                <span class="sr-only">{{ __('Toggle menu') }}</span>
                {{-- Height is 15px (not the nearer 14px step) so the three
                     bars split into two whole-pixel 6px gaps instead of
                     fractional 5.5px ones — keeping every bar edge, and the
                     translate distance below, on a whole pixel so the X's
                     crossing point can't drift a sub-pixel off-center from
                     browser to browser. --}}
                <span class="relative flex h-[15px] w-4 flex-col justify-between">
                    <span class="h-px w-full bg-current transition-transform duration-200 ease-in-out-strong group-aria-expanded:translate-y-[7px] group-aria-expanded:rotate-45"></span>
                    <span class="h-px w-full bg-current transition-opacity duration-150 ease-out group-aria-expanded:opacity-0"></span>
                    <span class="h-px w-full bg-current transition-transform duration-200 ease-in-out-strong group-aria-expanded:-translate-y-[7px] group-aria-expanded:-rotate-45"></span>
                </span>
            </button>
        </div>
    </div>

    <div
        id="mobile-nav"
        data-nav-menu
        data-open="false"
        class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out data-[open=true]:grid-rows-[1fr] min-[1450px]:hidden"
    >
        <nav class="overflow-hidden border-t border-hairline bg-cream" aria-label="Mobile">
            <div class="flex flex-col gap-1 px-6 py-5">
                @foreach ([...$links, ...$moreLinks] as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="rounded-lg px-3 py-2.5 text-base font-bold text-muted transition-colors hover:bg-surface hover:text-fg"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <x-ui.button href="{{ route('get-involved') }}" class="mt-2 justify-center">{{ __('Get Involved') }}</x-ui.button>
            </div>
        </nav>
    </div>
</header>

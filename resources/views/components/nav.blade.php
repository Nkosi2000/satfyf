@php
    // Every link's underline cycles through the logo colours while it's
    // hovered (see .nav-underline in app.css).
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

    // Centred secondary bar under the main one, shown/hidden by the
    // visitor (remembered per browser — see resources/js/modules/nav.js).
    // Shared with the footer via config/navigation.php; `danger` renders a
    // link in the brand red (Donate) so it stands out.
    $secondaryLinks = collect(config('navigation.secondary'))
        ->map(fn (array $link): array => [...$link, 'label' => __($link['label'])])
        ->all();

    $secondaryLinkColor = fn (array $link): string => ($link['danger'] ?? false)
        ? 'text-danger hover:text-danger-soft'
        : 'text-muted hover:text-fg'.(request()->routeIs($link['route']) ? ' text-fg' : '');
@endphp

{{--
    A full-width banner bar, pinned to the top of the viewport, with a
    quiet hairline edge and a translucent backdrop-blur ground instead of
    the old poster system's thick flag border. The ground lives on the bar
    row, not on <header>: a backdrop-filter on <header> would make it the
    backdrop root for the secondary tab below, so the tab couldn't blur the
    page behind it. Keeping the bar as a z-10 sibling also lets the tab
    slide up underneath it.
--}}
<header data-site-header class="sticky inset-x-0 top-0 z-50">
    {{-- max-width is a literal px value, not rem — the site's html { font-size:
         65% } scales every rem-based size down (by design, for page content),
         but that would also silently shrink this cap to ~1248px regardless of
         viewport width, starving the nav of room and wrapping link labels. --}}
    <div class="relative z-10 border-b border-hairline bg-cream/85 backdrop-blur">
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
                        <span class="nav-underline absolute inset-x-0 -bottom-0.5 h-0.5 origin-left scale-x-0 rounded-full transition-transform duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
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
                    <span class="nav-underline absolute inset-x-0 -bottom-0.5 h-0.5 origin-left scale-x-0 rounded-full transition-transform duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                </a>
            @endforeach
            <x-ui.button href="{{ route('get-involved') }}" size="sm">{{ __('Get Involved') }}</x-ui.button>
            <button
                type="button"
                data-secondary-nav-toggle
                aria-expanded="true"
                aria-controls="secondary-nav"
                class="group flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-surface-2 text-fg transition-colors hover:bg-surface"
            >
                <span class="sr-only">{{ __('Show or hide more links') }}</span>
                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4 transition-transform duration-200 ease-out group-aria-expanded:rotate-180" aria-hidden="true">
                    <path d="M5 7.5 10 12.5 15 7.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
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
    </div>

    {{-- Hangs from the bar's bottom edge as a centred tab (see the nav-tab
         utilities in app.css) instead of a full-width row, so it overlays
         the page rather than pushing it down. w-max sizes the tab to its
         links, so it grows or shrinks with however many there are. Sits
         below the z-10 bar, so closing slides it up underneath the bar. --}}
    <div id="secondary-nav" class="pointer-events-none absolute inset-x-0 top-full hidden justify-center min-[1450px]:flex">
        <nav data-secondary-nav aria-label="{{ __('Secondary') }}" class="nav-tab pointer-events-auto w-max">
            <span class="nav-tab-flare-left" aria-hidden="true"></span>
            <span class="nav-tab-flare-right" aria-hidden="true"></span>
            <div class="nav-tab-body flex items-center gap-x-10 px-10 py-3">
                @foreach ($secondaryLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="group relative py-1 text-sm font-bold whitespace-nowrap transition-colors {{ $secondaryLinkColor($link) }}"
                    >
                        {{ $link['label'] }}
                        <span class="absolute inset-x-0 -bottom-0.5 h-px origin-left scale-x-0 transition-transform duration-200 ease-out-strong group-hover:scale-x-100 {{ ($link['danger'] ?? false) ? 'bg-danger' : 'bg-primary-soft' }} {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                    </a>
                @endforeach
            </div>
        </nav>
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
                <div class="my-2 border-t border-hairline"></div>
                @foreach ($secondaryLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="rounded-lg px-3 py-2.5 text-sm font-bold transition-colors hover:bg-surface {{ $secondaryLinkColor($link) }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <x-ui.button href="{{ route('get-involved') }}" class="mt-2 justify-center">{{ __('Get Involved') }}</x-ui.button>
            </div>
        </nav>
    </div>
</header>

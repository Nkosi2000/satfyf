@php
    // Each link's hover underline cycles through the flag's four chromatic
    // colours (green, red, gold, blue) in a fixed rotation, continuing
    // across both link groups so the sequence reads as one continuous nav.
    $links = [
        ['label' => __('Home'), 'route' => 'home', 'accent' => 'bg-primary-soft'],
        ['label' => __('Who We Are'), 'route' => 'who-we-are', 'accent' => 'bg-danger-soft'],
        ['label' => __('Why We Exist'), 'route' => 'why-we-exist', 'accent' => 'bg-secondary-soft'],
        ['label' => __('What We Do'), 'route' => 'what-we-do', 'accent' => 'bg-tertiary'],
        ['label' => __('Articles'), 'route' => 'articles.index', 'accent' => 'bg-primary-soft'],
        ['label' => __('Events'), 'route' => 'events.index', 'accent' => 'bg-danger-soft'],
    ];

    $moreLinks = [
        ['label' => __('Resources'), 'route' => 'resources.index', 'accent' => 'bg-secondary-soft'],
        ['label' => __('Gallery'), 'route' => 'gallery', 'accent' => 'bg-tertiary'],
        ['label' => __('Partners'), 'route' => 'partners', 'accent' => 'bg-primary-soft'],
        ['label' => __('Contact Us'), 'route' => 'contact', 'accent' => 'bg-danger-soft'],
    ];
@endphp

<header data-site-header class="sticky top-0 z-50 border-b border-transparent transition-colors duration-300 [&.is-scrolled]:border-hairline [&.is-scrolled]:bg-ink/80 [&.is-scrolled]:backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-[120rem] items-center justify-between gap-8 px-6 py-5 sm:px-8">
        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2">
                <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="SATFYF" class="brand-mark h-12 w-auto rounded-md sm:h-14" />
            </a>

            <nav class="hidden items-center gap-8 min-[1450px]:flex" aria-label="Primary">
                @foreach ($links as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="group relative py-1 text-sm text-muted transition-colors hover:text-fg {{ request()->routeIs($link['route']) ? 'text-fg' : '' }}"
                    >
                        {{ $link['label'] }}
                        <span class="absolute inset-x-0 -bottom-0.5 h-px origin-left scale-x-0 {{ $link['accent'] }} transition-[transform,background-color] duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="hidden items-center gap-6 min-[1450px]:flex">
            @foreach ($moreLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="group relative py-1 text-sm text-muted transition-colors hover:text-fg {{ request()->routeIs($link['route']) ? 'text-fg' : '' }}"
                >
                    {{ $link['label'] }}
                    <span class="absolute inset-x-0 -bottom-0.5 h-px origin-left scale-x-0 {{ $link['accent'] }} transition-[transform,background-color] duration-200 ease-out-strong group-hover:scale-x-100 {{ request()->routeIs($link['route']) ? 'scale-x-100' : '' }}"></span>
                </a>
            @endforeach
            <x-ui.button href="{{ route('get-involved') }}" size="sm">{{ __('Get Involved') }}</x-ui.button>
            <x-language-switcher />
            <x-theme-toggle />
        </div>

        <div class="flex items-center gap-3 min-[1450px]:hidden">
            <x-language-switcher />
            <x-theme-toggle />

            <button
                type="button"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="mobile-nav"
                class="group flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-hairline-strong text-fg transition-colors hover:border-fg/30"
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
        <nav class="overflow-hidden border-t border-hairline" aria-label="Mobile">
            <div class="flex flex-col gap-1 px-6 py-5">
                @foreach ([...$links, ...$moreLinks] as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="rounded-lg px-3 py-2.5 text-sm text-muted transition-colors hover:bg-surface hover:text-fg"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <x-ui.button href="{{ route('get-involved') }}" class="mt-2 justify-center">{{ __('Get Involved') }}</x-ui.button>
            </div>
        </nav>
    </div>
</header>

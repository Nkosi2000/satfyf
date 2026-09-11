@php
    $links = [
        ['label' => 'Who We Are', 'route' => 'who-we-are'],
        ['label' => 'Why We Exist', 'route' => 'why-we-exist'],
        ['label' => 'What We Do', 'route' => 'what-we-do'],
        ['label' => 'Articles', 'route' => 'articles.index'],
        ['label' => 'Events', 'route' => 'events.index'],
    ];

    $moreLinks = [
        ['label' => 'Resources', 'route' => 'resources.index'],
        ['label' => 'Gallery', 'route' => 'gallery'],
        ['label' => 'Partners', 'route' => 'partners'],
        ['label' => 'Contact Us', 'route' => 'contact'],
    ];
@endphp

<header data-site-header class="sticky top-0 z-50 border-b border-transparent transition-colors duration-300 [&.is-scrolled]:border-hairline [&.is-scrolled]:bg-ink/80 [&.is-scrolled]:backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="SATFYF" class="h-9 w-auto rounded-md" />
        </a>

        <nav class="hidden items-center gap-7 lg:flex" aria-label="Primary">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="text-sm text-muted transition-colors hover:text-cream {{ request()->routeIs($link['route']) ? 'text-cream' : '' }}"
                >{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-5 lg:flex">
            @foreach ($moreLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="text-sm text-muted transition-colors hover:text-cream {{ request()->routeIs($link['route']) ? 'text-cream' : '' }}"
                >{{ $link['label'] }}</a>
            @endforeach
            <x-ui.button href="{{ route('get-involved') }}" size="sm">Get Involved</x-ui.button>
        </div>

        <button
            type="button"
            data-nav-toggle
            aria-expanded="false"
            aria-controls="mobile-nav"
            class="flex h-10 w-10 items-center justify-center rounded-full border border-hairline-strong text-cream lg:hidden"
        >
            <span class="sr-only">Toggle menu</span>
            <svg viewBox="0 0 20 20" fill="none" class="h-5 w-5" aria-hidden="true">
                <path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <div
        id="mobile-nav"
        data-nav-menu
        data-open="false"
        class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out data-[open=true]:grid-rows-[1fr] lg:hidden"
    >
        <nav class="overflow-hidden border-t border-hairline" aria-label="Mobile">
            <div class="flex flex-col gap-1 px-6 py-4">
                @foreach ([...$links, ...$moreLinks] as $link)
                    <a href="{{ route($link['route']) }}" class="rounded-lg px-3 py-2.5 text-sm text-muted hover:bg-surface hover:text-cream">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <x-ui.button href="{{ route('get-involved') }}" class="mt-2 justify-center">Get Involved</x-ui.button>
            </div>
        </nav>
    </div>
</header>

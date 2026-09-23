@props(['title' => 'Dashboard'])

@php
    $navSections = [
        null => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'grid'],
        ],
        'Pages' => [
            ['label' => 'Home', 'route' => 'admin.pages.edit', 'params' => ['page' => 'home'], 'icon' => 'home'],
            ['label' => 'Who We Are', 'route' => 'admin.pages.edit', 'params' => ['page' => 'who-we-are'], 'icon' => 'users'],
            ['label' => 'Why We Exist', 'route' => 'admin.pages.edit', 'params' => ['page' => 'why-we-exist'], 'icon' => 'info'],
            ['label' => 'What We Do', 'route' => 'admin.pages.edit', 'params' => ['page' => 'what-we-do'], 'icon' => 'layers'],
            ['label' => 'Get Involved', 'route' => 'admin.pages.edit', 'params' => ['page' => 'get-involved'], 'icon' => 'heart'],
            ['label' => 'Contact', 'route' => 'admin.pages.edit', 'params' => ['page' => 'contact'], 'icon' => 'mail'],
            ['label' => 'Privacy & Cookies', 'route' => 'admin.pages.edit', 'params' => ['page' => 'privacy'], 'icon' => 'shield'],
        ],
        'Content' => [
            ['label' => 'Articles', 'route' => 'admin.articles.index', 'icon' => 'document'],
            ['label' => 'Events', 'route' => 'admin.events.index', 'icon' => 'calendar'],
            ['label' => 'Programmes', 'route' => 'admin.programs.index', 'icon' => 'layers'],
            ['label' => 'Team', 'route' => 'admin.team-members.index', 'icon' => 'users'],
            ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'quote'],
            ['label' => 'Resources', 'route' => 'admin.resources.index', 'icon' => 'download'],
            ['label' => 'Gallery', 'route' => 'admin.gallery-images.index', 'icon' => 'image'],
            ['label' => 'Partners', 'route' => 'admin.partners.index', 'icon' => 'link'],
            ['label' => 'FAQs', 'route' => 'admin.faqs.index', 'icon' => 'question'],
        ],
        'Organisation' => [
            ['label' => 'Mission & Vision', 'route' => 'admin.organisation.edit', 'params' => ['page' => 'mission'], 'icon' => 'target'],
            ['label' => 'Social Media', 'route' => 'admin.organisation.edit', 'params' => ['page' => 'social'], 'icon' => 'share'],
            ['label' => 'Footer', 'route' => 'admin.organisation.edit', 'params' => ['page' => 'footer'], 'icon' => 'layout-bottom'],
        ],
        'Admin' => [
            ['label' => 'Contact submissions', 'route' => 'admin.contact-submissions.index', 'icon' => 'inbox'],
            ['label' => 'Newsletter subscribers', 'route' => 'admin.newsletter-subscribers.index', 'icon' => 'send'],
            ['label' => 'My Account', 'route' => 'admin.account.edit', 'icon' => 'user-circle'],
        ],
    ];

    // Every Pages/Organisation nav item shares one route name per section
    // (only the `page` route param differs), so a plain routeIs() check
    // would light up every item in that section at once — compare the
    // `page` param too. Content/Admin items are plain resource routes
    // (admin.articles.index, admin.account.edit, ...): stay highlighted on
    // their create/edit/store siblings by matching the route name's
    // resource prefix, not just the exact name — admin.dashboard has no
    // such siblings, so it's matched exactly instead.
    $isNavItemActive = function (array $item): bool {
        if (isset($item['params']['page'])) {
            return request()->routeIs($item['route']) && request()->route('page') === $item['params']['page'];
        }

        if (substr_count($item['route'], '.') < 2) {
            return request()->routeIs($item['route']);
        }

        return request()->routeIs(\Illuminate\Support\Str::beforeLast($item['route'], '.').'.*');
    };

    $activeSection = null;
    $activeItem = null;

    foreach ($navSections as $heading => $items) {
        foreach ($items as $item) {
            if ($isNavItemActive($item)) {
                $activeSection = $heading;
                $activeItem = $item;
                break 2;
            }
        }
    }

    $breadcrumbs = collect();

    if ($activeItem) {
        $breadcrumbs->push(['label' => 'Dashboard', 'route' => route('admin.dashboard')]);

        if ($activeSection) {
            $breadcrumbs->push(['label' => $activeSection, 'route' => null]);
        }

        if ($activeItem['route'] !== 'admin.dashboard') {
            $breadcrumbs->push(['label' => $activeItem['label'], 'route' => route($activeItem['route'], $activeItem['params'] ?? [])]);
        }

        if ($title !== $activeItem['label']) {
            $breadcrumbs->push(['label' => $title, 'route' => null]);
        }
    } else {
        $breadcrumbs->push(['label' => $title, 'route' => null]);
    }
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title }} · SATFYF Admin</title>
    <link rel="icon" href="{{ asset('images/48 x 48.png') }}" />

    <script>
        // Runs before first paint to avoid a flash of the wrong theme —
        // mirrors the public site's inline script, same localStorage key,
        // so the admin follows whichever mode the visitor last chose.
        if (localStorage.getItem('color-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Same technique, same reasoning, for the sidebar's collapsed
        // width — set on <html> (which exists immediately) rather than on
        // the sidebar itself (which doesn't exist yet), so there's no
        // flash of the wrong width once the sidebar renders.
        if (localStorage.getItem('admin-sidebar-collapsed') === 'true') {
            document.documentElement.classList.add('admin-sidebar-collapsed');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-fg antialiased">
    <div class="flex min-h-screen">
        <aside data-admin-sidebar class="hidden shrink-0 border-r border-hairline-strong bg-surface lg:flex lg:flex-col">
            <div class="flex h-16 items-center justify-between gap-2 border-b border-hairline-strong px-5">
                <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-2.5">
                    <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-9 w-9 shrink-0 rounded-full object-cover" />
                    <span data-nav-label class="truncate text-sm font-semibold text-fg">Admin</span>
                </a>
                <button
                    type="button"
                    data-sidebar-toggle
                    aria-expanded="true"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-muted transition-colors hover:bg-surface-2 hover:text-fg"
                >
                    <span class="sr-only">Collapse sidebar</span>
                    <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4 transition-transform duration-200" aria-hidden="true">
                        <path d="M12.5 5 7.5 10l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-4 overflow-y-auto p-3">
                @foreach ($navSections as $heading => $items)
                    <div class="flex flex-col gap-0.5">
                        @if ($heading)
                            <p data-nav-section-heading class="px-3 pb-1 text-xs font-bold tracking-wider text-faint uppercase">{{ $heading }}</p>
                        @endif
                        @foreach ($items as $item)
                            <a
                                href="{{ route($item['route'], $item['params'] ?? []) }}"
                                title="{{ $item['label'] }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $isNavItemActive($item) ? 'bg-primary text-on-accent' : 'text-muted hover:bg-surface-2 hover:text-fg' }}"
                            >
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center">
                                    <x-admin.icon :name="$item['icon']" class="h-5 w-5" />
                                </span>
                                <span data-nav-label class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center justify-between gap-4 border-b border-hairline-strong bg-surface px-4 sm:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        type="button"
                        data-nav-toggle
                        aria-expanded="false"
                        aria-controls="admin-mobile-nav"
                        class="group flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-hairline-strong text-fg transition-colors hover:border-fg/30 lg:hidden"
                    >
                        <span class="sr-only">Toggle menu</span>
                        <span class="relative flex h-3.5 w-4 flex-col justify-between">
                            <span class="h-px w-full bg-current transition-transform duration-200 ease-in-out-strong group-aria-expanded:translate-y-[6.5px] group-aria-expanded:rotate-45"></span>
                            <span class="h-px w-full bg-current transition-opacity duration-150 ease-out group-aria-expanded:opacity-0"></span>
                            <span class="h-px w-full bg-current transition-transform duration-200 ease-in-out-strong group-aria-expanded:-translate-y-[6.5px] group-aria-expanded:-rotate-45"></span>
                        </span>
                    </button>
                    <h1 class="truncate text-lg font-semibold text-fg">{{ $title }}</h1>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="hidden text-sm text-muted transition-colors hover:text-fg sm:inline">View site &rarr;</a>
                    <x-theme-toggle class="h-9 w-9" />
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-muted transition-colors hover:text-fg">Log out</button>
                    </form>
                </div>
            </header>

            <div
                id="admin-mobile-nav"
                data-nav-menu
                data-open="false"
                class="grid grid-rows-[0fr] border-b border-hairline-strong bg-surface transition-[grid-template-rows] duration-300 ease-out data-[open=true]:grid-rows-[1fr] lg:hidden"
            >
                <nav class="max-h-[70vh] overflow-y-auto">
                    <div class="flex flex-col gap-4 p-3">
                        @foreach ($navSections as $heading => $items)
                            <div class="flex flex-col gap-1">
                                @if ($heading)
                                    <p class="px-3 pb-1 text-xs font-bold tracking-wider text-faint uppercase">{{ $heading }}</p>
                                @endif
                                @foreach ($items as $item)
                                    <a
                                        href="{{ route($item['route'], $item['params'] ?? []) }}"
                                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ $isNavItemActive($item) ? 'bg-primary text-on-accent' : 'text-muted hover:bg-surface-2 hover:text-fg' }}"
                                    >
                                        <span class="flex h-5 w-5 shrink-0 items-center justify-center">
                                            <x-admin.icon :name="$item['icon']" class="h-5 w-5" />
                                        </span>
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </nav>
            </div>

            <main class="flex-1 p-4 sm:p-6">
                <nav aria-label="Breadcrumb" class="mb-4 flex flex-wrap items-center gap-1.5 text-sm">
                    @foreach ($breadcrumbs as $crumb)
                        @if (! $loop->last && $crumb['route'])
                            <a href="{{ $crumb['route'] }}" class="text-muted hover:text-fg">{{ $crumb['label'] }}</a>
                        @else
                            <span class="{{ $loop->last ? 'font-semibold text-fg' : 'text-muted' }}">{{ $crumb['label'] }}</span>
                        @endif
                        @unless ($loop->last)
                            <span aria-hidden="true" class="text-faint">/</span>
                        @endunless
                    @endforeach
                </nav>

                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-hairline-strong bg-primary/10 px-4 py-3 text-sm text-primary">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

@props(['title' => 'Dashboard'])

@php
    // Every settings-page nav item shares the one `admin.settings.edit`
    // route name (only the `page` route param differs), so a plain
    // routeIs() check would light up every one of them at once — $isActive
    // additionally compares the current `page` param for those items.
    $navSections = [
        null => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ],
        'Pages' => [
            ['label' => 'Home', 'route' => 'admin.settings.edit', 'params' => ['page' => 'home']],
            ['label' => 'Who We Are', 'route' => 'admin.settings.edit', 'params' => ['page' => 'who-we-are']],
            ['label' => 'Why We Exist', 'route' => 'admin.settings.edit', 'params' => ['page' => 'why-we-exist']],
            ['label' => 'What We Do', 'route' => 'admin.settings.edit', 'params' => ['page' => 'what-we-do']],
            ['label' => 'Get Involved', 'route' => 'admin.settings.edit', 'params' => ['page' => 'get-involved']],
            ['label' => 'Contact', 'route' => 'admin.settings.edit', 'params' => ['page' => 'contact']],
            ['label' => 'Privacy & Cookies', 'route' => 'admin.settings.edit', 'params' => ['page' => 'privacy']],
        ],
        'Content' => [
            ['label' => 'Articles', 'route' => 'admin.articles.index'],
            ['label' => 'Events', 'route' => 'admin.events.index'],
            ['label' => 'Programmes', 'route' => 'admin.programs.index'],
            ['label' => 'Team', 'route' => 'admin.team-members.index'],
            ['label' => 'Testimonials', 'route' => 'admin.testimonials.index'],
            ['label' => 'Resources', 'route' => 'admin.resources.index'],
            ['label' => 'Gallery', 'route' => 'admin.gallery-images.index'],
            ['label' => 'Partners', 'route' => 'admin.partners.index'],
            ['label' => 'FAQs', 'route' => 'admin.faqs.index'],
        ],
        'Organisation' => [
            ['label' => 'Mission & Vision', 'route' => 'admin.settings.edit', 'params' => ['page' => 'mission']],
            ['label' => 'Social Media', 'route' => 'admin.settings.edit', 'params' => ['page' => 'social']],
            ['label' => 'Footer', 'route' => 'admin.settings.edit', 'params' => ['page' => 'footer']],
        ],
        'Admin' => [
            ['label' => 'Contact submissions', 'route' => 'admin.contact-submissions.index'],
            ['label' => 'Newsletter subscribers', 'route' => 'admin.newsletter-subscribers.index'],
            ['label' => 'My Account', 'route' => 'admin.account.edit'],
        ],
    ];

    $isNavItemActive = fn (array $item): bool => isset($item['params']['page'])
        ? request()->routeIs($item['route']) && request()->route('page') === $item['params']['page']
        : request()->routeIs($item['route'].'*');
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
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-fg antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 border-r border-hairline-strong bg-surface lg:block">
            <a href="{{ route('admin.dashboard') }}" class="flex h-16 items-center gap-2.5 border-b border-hairline-strong px-5">
                <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-9 w-9 rounded-full object-cover" />
                <span class="text-sm font-semibold text-fg">Admin</span>
            </a>
            <nav class="flex flex-col gap-4 overflow-y-auto p-3">
                @foreach ($navSections as $heading => $items)
                    <div class="flex flex-col gap-0.5">
                        @if ($heading)
                            <p class="px-3 pb-1 text-xs font-bold tracking-wider text-faint uppercase">{{ $heading }}</p>
                        @endif
                        @foreach ($items as $item)
                            <a
                                href="{{ route($item['route'], $item['params'] ?? []) }}"
                                class="rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $isNavItemActive($item) ? 'bg-primary text-on-accent' : 'text-muted hover:bg-surface-2 hover:text-fg' }}"
                            >{{ $item['label'] }}</a>
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
                                        class="rounded-lg px-3 py-2.5 text-sm font-medium {{ $isNavItemActive($item) ? 'bg-primary text-on-accent' : 'text-muted hover:bg-surface-2 hover:text-fg' }}"
                                    >{{ $item['label'] }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </nav>
            </div>

            <main class="flex-1 p-4 sm:p-6">
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

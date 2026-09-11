@props(['title' => 'Dashboard'])

@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ['label' => 'Articles', 'route' => 'admin.articles.index'],
        ['label' => 'Events', 'route' => 'admin.events.index'],
        ['label' => 'Programmes', 'route' => 'admin.programs.index'],
        ['label' => 'Team', 'route' => 'admin.team-members.index'],
        ['label' => 'Resources', 'route' => 'admin.resources.index'],
        ['label' => 'Gallery', 'route' => 'admin.gallery-images.index'],
        ['label' => 'Partners', 'route' => 'admin.partners.index'],
        ['label' => 'FAQs', 'route' => 'admin.faqs.index'],
        ['label' => 'Contact submissions', 'route' => 'admin.contact-submissions.index'],
        ['label' => 'Newsletter subscribers', 'route' => 'admin.newsletter-subscribers.index'],
        ['label' => 'Site settings', 'route' => 'admin.settings.edit'],
    ];
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title }} · SATFYF Admin</title>
    <link rel="icon" href="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white lg:block">
            <div class="flex h-16 items-center gap-2 border-b border-slate-200 px-5">
                <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="SATFYF" class="h-8 w-auto rounded" />
                <span class="text-sm font-semibold">Admin</span>
            </div>
            <nav class="flex flex-col gap-0.5 p-3">
                @foreach ($nav as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs($item['route'].'*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}"
                    >{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">
                <h1 class="text-lg font-semibold">{{ $title }}</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-sm text-slate-500 hover:text-slate-900">View site &rarr;</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-900">Log out</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

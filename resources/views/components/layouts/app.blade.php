@props([
    'title' => null,
    'description' => null,
])

@php
    $description = $description ?? __('Youth voices championing and fighting against the harsh and dangerous realities of tobacco, substance and drug abuse amongst young people.');
@endphp

<!doctype html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $title ? "$title · SATFYF" : __('SATFYF | South African Tobacco-Free Youth Forum') }}</title>
    <meta name="description" content="{{ $description }}" />

    <link rel="icon" href="{{ asset('images/48 x 48.png') }}" />

    <script>
        // Runs before first paint to avoid a flash of the wrong theme.
        // Light is always the default — dark applies only once someone has
        // explicitly switched to it via the toggle, regardless of the
        // visitor's OS-level colour scheme preference.
        if (localStorage.getItem('color-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Same pre-paint trick for the secondary nav bar (see x-nav and
        // resources/js/modules/nav.js) so a hidden bar doesn't flash open.
        try {
            if (localStorage.getItem('secondary-nav') === 'closed') {
                document.documentElement.classList.add('secondary-nav-closed');
            }
        } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans antialiased">
    <div class="ambient-backdrop" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    {{--
        One site-wide fluid-smoke canvas rather than one per section: the
        effect is transparent by default and already meant to blend into
        whatever sits behind it, so a single fixed layer behind the entire
        page reads the same as many separate ones would, at a fraction of
        the WebGL cost (one context and one shader compile per page load).
        The sticky nav's bar is 85% opaque cream, so the smoke only shows
        through it as a faint blur.
    --}}
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
        <x-ui.fluid-smoke :speed="0.25" :scale="1.1" :warp="0.9" :rise="0.25" :swirl="0.2" :contrast="1.4" :softness="0.45" :mouse="0.3" />
    </div>
    <div class="site-edge-accent" aria-hidden="true"></div>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <x-nav />

    <main>
        {{ $slot }}
    </main>

    <x-footer />
    <x-chatbot />
    <x-back-to-top />
    <x-cookie-banner />
</body>
</html>

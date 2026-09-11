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

    <title>{{ $title ? "$title · SATFYF" : __('SATFYF — South African Tobacco-Free Youth Forum') }}</title>
    <meta name="description" content="{{ $description }}" />

    <link rel="icon" href="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" />

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
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink font-sans antialiased">
    <x-nav />

    <main>
        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>

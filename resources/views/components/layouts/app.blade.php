@props([
    'title' => null,
    'description' => 'Youth voices championing and fighting against the harsh and dangerous realities of tobacco, substance and drug abuse amongst young people.',
])

<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $title ? "$title · SATFYF" : 'SATFYF — South African Tobacco-Free Youth Forum' }}</title>
    <meta name="description" content="{{ $description }}" />

    <link rel="icon" href="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" />

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

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin Login · SATFYF</title>
    <link rel="icon" href="{{ asset('images/48 x 48.png') }}" />

    <script>
        if (localStorage.getItem('color-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center bg-ink px-4 font-sans text-fg antialiased">
    <x-theme-toggle class="absolute right-4 top-4 sm:right-6 sm:top-6" />

    <div class="w-full max-w-sm rounded-2xl border border-hairline-strong bg-surface p-8 shadow-sm">
        <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-12 w-12 rounded-full object-cover" />
        <h1 class="mt-6 text-xl font-semibold text-fg">Admin sign in</h1>
        <p class="mt-1 text-sm text-muted">Manage the SATFYF website.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-danger-soft/30 bg-danger-soft/10 px-4 py-3 text-sm text-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 flex flex-col gap-4">
            @csrf
            <x-admin.field name="email" label="Email" type="email" />
            <x-admin.field name="password" label="Password" type="password" />

            <label class="flex items-center gap-2 text-sm text-muted">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-hairline-strong accent-primary" />
                Remember me
            </label>

            <x-ui.button type="submit" class="mt-2 w-full">Sign in</x-ui.button>
        </form>
    </div>
</body>
</html>

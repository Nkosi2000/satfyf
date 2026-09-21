<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Forgot Password · SATFYF Admin</title>
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
<body class="relative flex min-h-screen items-center justify-center bg-cream px-4 font-sans text-fg antialiased">
    <x-theme-toggle class="absolute right-4 top-4 sm:right-6 sm:top-6" />

    <div class="w-full max-w-2xl rounded-2xl border border-hairline bg-surface p-10" style="box-shadow: var(--shadow-soft)">
        <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-14 w-14 rounded-full object-cover" />
        <h1 class="mt-6 text-2xl font-semibold text-fg">Forgot your password?</h1>
        <p class="mt-1 text-base text-muted">Enter your email and we'll send you a reset link.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-primary-soft/30 bg-primary-soft/10 px-4 py-3 text-sm text-primary">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-danger-soft/30 bg-danger-soft/10 px-4 py-3 text-sm text-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}" class="mt-6 flex flex-col gap-4">
            @csrf
            <x-admin.field name="email" label="Email" type="email" />

            <x-ui.button type="submit" class="mt-2 w-full">Send reset link</x-ui.button>
        </form>

        <a href="{{ route('admin.login') }}" class="mt-6 block text-center text-sm text-muted hover:text-fg">&larr; Back to sign in</a>
    </div>
</body>
</html>

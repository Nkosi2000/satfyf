<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login · SATFYF</title>
    <link rel="icon" href="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="SATFYF" class="h-10 w-auto rounded" />
        <h1 class="mt-6 text-xl font-semibold">Admin sign in</h1>
        <p class="mt-1 text-sm text-slate-500">Manage the SATFYF website.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 flex flex-col gap-4">
            @csrf
            <x-admin.field name="email" label="Email" type="email" />
            <x-admin.field name="password" label="Password" type="password" />

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300" />
                Remember me
            </label>

            <button type="submit" class="mt-2 w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                Sign in
            </button>
        </form>
    </div>
</body>
</html>

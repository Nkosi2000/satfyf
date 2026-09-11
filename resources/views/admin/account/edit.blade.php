<x-admin.layout title="My Account">
    <div class="max-w-md rounded-xl border border-hairline-strong bg-surface p-6">
        <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
        <p class="text-sm text-muted">{{ auth()->user()->email }}</p>

        <h3 class="mt-6 text-sm font-semibold">Change password</h3>
        <form method="POST" action="{{ route('admin.account.password.update') }}" class="mt-4 flex flex-col gap-5">
            @csrf
            @method('PUT')
            <x-admin.field name="current_password" label="Current password" type="password" />
            <x-admin.field name="password" label="New password" type="password" />
            <x-admin.field name="password_confirmation" label="Confirm new password" type="password" />

            <x-ui.button type="submit" size="sm">Update password</x-ui.button>
        </form>
    </div>
</x-admin.layout>

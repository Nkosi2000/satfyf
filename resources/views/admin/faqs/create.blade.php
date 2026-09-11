<x-admin.layout title="Add FAQ">
    <form method="POST" action="{{ route('admin.faqs.store') }}" class="max-w-2xl rounded-xl border border-hairline-strong bg-surface p-6">
        @csrf
        @include('admin.faqs._form')

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button type="submit" size="sm">Save</x-ui.button>
            <a href="{{ route('admin.faqs.index') }}" class="text-sm text-muted hover:text-fg">Cancel</a>
        </div>
    </form>
</x-admin.layout>

<x-admin.layout title="Write article">
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-hairline-strong bg-surface p-6">
        @csrf
        @include('admin.articles._form')

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button type="submit" size="sm">Save</x-ui.button>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-muted hover:text-fg">Cancel</a>
        </div>
    </form>
</x-admin.layout>

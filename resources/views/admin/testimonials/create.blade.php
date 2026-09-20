<x-admin.layout title="Add testimonial">
    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="max-w-2xl rounded-xl border border-hairline-strong bg-surface p-6">
        @csrf
        @include('admin.testimonials._form')

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button type="submit" size="sm">Save</x-ui.button>
            <a href="{{ route('admin.testimonials.index') }}" class="text-sm text-muted hover:text-fg">Cancel</a>
        </div>
    </form>
</x-admin.layout>

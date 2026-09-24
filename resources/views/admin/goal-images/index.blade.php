<x-admin.layout title="Goals Slideshow">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-muted">
            {{ $images->count() }} {{ Str::plural('image', $images->count()) }} · rotating beside "Goals &amp; Objectives" on the Who We Are page, lowest order first.
        </p>
        <x-ui.button href="{{ route('admin.goal-images.create') }}" size="sm">Add image</x-ui.button>
    </div>

    @if ($images->isEmpty())
        <p class="mt-6 rounded-xl border border-hairline-strong bg-surface p-6 text-sm text-muted">No images yet. The section shows its text without a slideshow until you add one.</p>
    @endif

    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($images as $image)
            <div class="overflow-hidden rounded-xl border border-hairline-strong bg-surface">
                <img
                    src="{{ storage_url($image->image_path) }}"
                    alt="{{ $image->caption }}"
                    class="h-40 w-full object-cover"
                />
                <div class="p-3">
                    <p class="truncate text-sm font-medium">{{ $image->caption ?: 'Untitled' }}</p>
                    <p class="text-xs text-muted">Order {{ $image->order }}</p>
                    <div class="mt-2 flex items-center gap-3 text-sm">
                        <a href="{{ route('admin.goal-images.edit', $image) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                        <form method="POST" action="{{ route('admin.goal-images.destroy', $image) }}" onsubmit="return confirm('Delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-danger-soft hover:text-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-admin.layout>

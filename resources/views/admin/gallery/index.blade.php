<x-admin.layout title="Gallery">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $images->total() }} images</p>
        <x-ui.button href="{{ route('admin.gallery-images.create') }}" size="sm">Add image</x-ui.button>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($images as $image)
            <div class="overflow-hidden rounded-xl border border-hairline-strong bg-surface">
                <img
                    src="{{ storage_url($image->image_path) }}"
                    alt="{{ $image->caption }}"
                    class="h-32 w-full object-cover"
                />
                <div class="p-3">
                    <p class="truncate text-sm font-medium">{{ $image->caption ?: 'Untitled' }}</p>
                    <p class="text-xs text-muted">{{ $image->category }}</p>
                    <div class="mt-2 flex items-center gap-3 text-sm">
                        <a href="{{ route('admin.gallery-images.edit', $image) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                        <form method="POST" action="{{ route('admin.gallery-images.destroy', $image) }}" onsubmit="return confirm('Delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-danger-soft hover:text-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $images->links() }}</div>
</x-admin.layout>

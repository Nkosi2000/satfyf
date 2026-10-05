<x-admin.layout title="Gallery">
    <x-admin.page-header-panel page="gallery-page" :settings="$pageSettings" />

    <div data-gallery-hero-panel class="mb-6 rounded-xl border border-hairline-strong bg-surface p-6">
        <h2 class="font-semibold">Page hero image</h2>
        <p class="mt-1 text-sm text-muted">
            The large image beside the heading at the top of the public Gallery page.
            @unless ($heroImagePath)
                None uploaded yet, so the first gallery image below is used.
            @endunless
        </p>

        <div class="mt-4 flex flex-wrap items-start gap-6">
            @if ($heroImagePath)
                <img src="{{ storage_url($heroImagePath) }}" alt="Current Gallery page hero image" class="h-32 w-26 rounded-lg object-cover" />
            @endif

            <form method="POST" action="{{ route('admin.gallery-hero-image.update') }}" enctype="multipart/form-data" class="flex min-w-0 flex-1 flex-col gap-3">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-1.5">
                    <input type="file" name="image" accept="image/*" required class="w-full max-w-md rounded-lg border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg file:mr-3 file:rounded-md file:border-0 file:bg-surface-2 file:px-3 file:py-1.5 file:text-sm file:text-fg" />
                    <p class="text-xs text-muted">Shown in a portrait (4:5) frame — keep the subject near the centre.</p>
                    @error('image')
                        <p class="text-xs text-danger-soft">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <x-ui.button type="submit" size="sm">{{ $heroImagePath ? 'Replace image' : 'Upload image' }}</x-ui.button>
                </div>
            </form>

            @if ($heroImagePath)
                <form method="POST" action="{{ route('admin.gallery-hero-image.destroy') }}" onsubmit="return confirm('Remove the hero image? The first gallery image will be used instead.')" class="self-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-danger-soft hover:text-danger">Remove</button>
                </form>
            @endif
        </div>
    </div>

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

<x-admin.layout title="Edit article">
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-hairline-strong bg-surface p-6">
        @csrf
        @method('PUT')
        @include('admin.articles._form')

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button type="submit" size="sm">Save changes</x-ui.button>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-muted hover:text-fg">Cancel</a>
        </div>
    </form>

    <div class="mt-6 max-w-3xl rounded-xl border border-hairline-strong bg-surface p-6">
        <h2 class="font-semibold text-fg">Body images</h2>
        <p class="mt-1 text-sm text-muted">Shown at the bottom of the article, below the body text — not inline with the writing. Uploading adds to the images already here.</p>

        @if ($images->isNotEmpty())
            <div class="mt-4 grid grid-cols-3 gap-3 sm:grid-cols-4">
                @foreach ($images as $image)
                    <div class="group relative aspect-square overflow-hidden rounded-lg border border-hairline-strong">
                        <img src="{{ storage_url($image->image_path) }}" alt="" class="h-full w-full object-cover" />
                        <form
                            method="POST"
                            action="{{ route('admin.articles.images.destroy', [$article, $image]) }}"
                            onsubmit="return confirm('Remove this image?')"
                            class="absolute top-1.5 right-1.5"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                aria-label="Remove image"
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-ink/70 text-fg opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                &times;
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-muted">No images yet.</p>
        @endif

        <form method="POST" action="{{ route('admin.articles.images.store', $article) }}" enctype="multipart/form-data" class="mt-5 flex flex-wrap items-end gap-3">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label for="field-images" class="text-sm font-medium text-fg">Add images</label>
                <input
                    id="field-images"
                    type="file"
                    name="images[]"
                    accept="image/*"
                    multiple
                    class="rounded-lg border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg file:mr-3 file:rounded-md file:border-0 file:bg-surface-2 file:px-3 file:py-1.5 file:text-sm file:text-fg"
                />
                @error('images') <p class="text-xs text-danger-soft">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-xs text-danger-soft">{{ $message }}</p> @enderror
            </div>
            <x-ui.button type="submit" variant="secondary" size="sm">Upload</x-ui.button>
        </form>
    </div>
</x-admin.layout>

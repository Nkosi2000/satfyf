<x-admin.layout title="Gallery">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $images->total() }} images</p>
        <a href="{{ route('admin.gallery-images.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add image</a>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($images as $image)
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <img
                    src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                    alt="{{ $image->caption }}"
                    class="h-32 w-full object-cover"
                />
                <div class="p-3">
                    <p class="truncate text-sm font-medium">{{ $image->caption ?: 'Untitled' }}</p>
                    <p class="text-xs text-slate-500">{{ $image->category }}</p>
                    <div class="mt-2 flex items-center gap-3 text-sm">
                        <a href="{{ route('admin.gallery-images.edit', $image) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                        <form method="POST" action="{{ route('admin.gallery-images.destroy', $image) }}" onsubmit="return confirm('Delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $images->links() }}</div>
</x-admin.layout>

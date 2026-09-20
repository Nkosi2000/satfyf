@php($image = $image ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="caption" label="Caption" :value="$image?->caption" />
    <x-admin.field name="category" label="Category" :value="$image?->category" />
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
        <label class="text-sm font-medium text-fg">Image</label>
        <input type="file" name="image" accept="image/*" data-image-input="image" class="w-full rounded-lg border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg file:mr-3 file:rounded-md file:border-0 file:bg-surface-2 file:px-3 file:py-1.5 file:text-sm file:text-fg" />
        <img
            data-image-preview="image"
            src="{{ storage_url($image?->image_path) }}"
            @if (! $image) hidden @endif
            class="mt-2 h-20 w-20 rounded-lg object-cover"
            alt=""
        />
        @error('image')
            <p class="text-xs text-danger-soft">{{ $message }}</p>
        @enderror
    </div>
    <x-admin.field name="order" label="Order" type="number" :value="$image?->order ?? 0" />
</div>

@php($resource = $resource ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.translatable-field name="title" label="Title" :translations="$resource?->translations('title') ?? []" />
    <x-admin.translatable-field name="category" label="Category" :translations="$resource?->translations('category') ?? []" />
</div>

<x-admin.translatable-field name="description" label="Description" type="textarea" :translations="$resource?->translations('description') ?? []" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
        <label class="text-sm font-medium text-fg">File</label>
        <input type="file" name="file" class="w-full rounded-lg border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg file:mr-3 file:rounded-md file:border-0 file:bg-surface-2 file:px-3 file:py-1.5 file:text-sm file:text-fg" />
        @if ($resource)
            <p class="text-xs text-muted">Current file: {{ basename($resource->file_path) }}</p>
        @endif
        @error('file')
            <p class="text-xs text-danger-soft">{{ $message }}</p>
        @enderror
    </div>
    <x-admin.field name="published" label="Published" type="checkbox" :value="$resource?->published ?? true" />
</div>

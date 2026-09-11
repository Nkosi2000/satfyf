@php($resource = $resource ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="title" label="Title" :value="$resource?->title" />
    <x-admin.field name="category" label="Category" :value="$resource?->category" />
</div>

<x-admin.field name="description" label="Description" type="textarea" :value="$resource?->description" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
        <label class="text-sm font-medium text-slate-700">File</label>
        <input type="file" name="file" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-sm" />
        @if ($resource)
            <p class="text-xs text-slate-500">Current file: {{ basename($resource->file_path) }}</p>
        @endif
        @error('file')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <x-admin.field name="published" label="Published" type="checkbox" :value="$resource?->published ?? true" />
</div>

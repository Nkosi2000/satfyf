@php($article = $article ?? null)

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.field name="title" label="Title" :value="$article?->title" />
    <x-admin.field name="slug" label="Slug" :value="$article?->slug" hint="Used in the article URL." />
</div>

<x-admin.field name="excerpt" label="Excerpt" type="textarea" :value="$article?->excerpt" class="mt-5" hint="Shown on listing pages." />

<div class="mt-5" data-markdown-field="{{ route('admin.markdown-preview') }}">
    <div class="mb-1.5 flex items-center justify-between">
        <label class="text-sm font-medium text-slate-700">Body (Markdown supported)</label>
        <div class="flex items-center gap-1 rounded-lg bg-slate-100 p-1 text-xs font-medium">
            <button type="button" data-markdown-tab="write" aria-selected="true" class="rounded-md px-2.5 py-1 aria-selected:bg-white aria-selected:shadow-sm">Write</button>
            <button type="button" data-markdown-tab="preview" aria-selected="false" class="rounded-md px-2.5 py-1 aria-selected:bg-white aria-selected:shadow-sm">Preview</button>
        </div>
    </div>
    <textarea name="body" rows="14" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm text-slate-900 focus:border-slate-500 focus:outline-none">{{ old('body', $article?->body) }}</textarea>
    <div
        data-markdown-preview
        hidden
        class="min-h-40 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 [&_a]:underline [&_h1]:mt-4 [&_h1]:text-lg [&_h1]:font-semibold [&_h2]:mt-4 [&_h2]:text-base [&_h2]:font-semibold [&_li]:ml-5 [&_p]:mb-3 [&_ul]:list-disc"
    ></div>
    @error('body')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-3">
    <x-admin.field name="cover_image" label="Cover image" type="file" :value="$article?->cover_image_path" />
    <x-admin.field name="author_name" label="Author" :value="$article?->author_name" />
    <x-admin.field
        name="published_at"
        label="Publish at"
        type="datetime-local"
        :value="$article?->published_at?->format('Y-m-d\TH:i')"
        hint="Leave blank to save as a draft."
    />
</div>

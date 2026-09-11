@php
    $article = $article ?? null;
    $localeLabels = ['zu' => 'isiZulu', 'st' => 'Sesotho', 'af' => 'Afrikaans'];
    $bodies = $article?->translations('body') ?? [];
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <x-admin.translatable-field name="title" label="Title" :translations="$article?->translations('title') ?? []" />
    <x-admin.field name="slug" label="Slug" :value="$article?->slug" hint="Used in the article URL." />
</div>

<x-admin.translatable-field name="excerpt" label="Excerpt" type="textarea" :translations="$article?->translations('excerpt') ?? []" hint="Shown on listing pages." class="mt-5" />

@php
    $bodyLocales = ['en' => 'English', ...$localeLabels];
@endphp

<div class="mt-5">
    <label class="text-sm font-medium text-fg">Body (Markdown supported)</label>

    @foreach ($bodyLocales as $code => $label)
        @php($bodyField = "body-{$code}")

        @if ($code === 'en')
            <div class="mt-1.5" data-markdown-field="{{ route('admin.markdown-preview') }}">
                <div class="mb-1.5 flex items-center justify-between">
                    <span class="text-xs font-medium text-muted">{{ $label }}</span>
                    <div class="flex items-center gap-1 rounded-lg bg-surface-2 p-1 text-xs font-medium">
                        <button type="button" data-markdown-tab="write" aria-selected="true" class="rounded-md px-2.5 py-1 aria-selected:bg-surface aria-selected:shadow-sm">Write</button>
                        <button type="button" data-markdown-tab="preview" aria-selected="false" class="rounded-md px-2.5 py-1 aria-selected:bg-surface aria-selected:shadow-sm">Preview</button>
                    </div>
                </div>
                <textarea id="field-{{ $bodyField }}" name="body[en]" rows="14" class="w-full rounded-lg border border-hairline-strong bg-surface px-3 py-2 font-mono text-sm text-fg focus:border-primary-soft focus:outline-none">{{ old('body.en', $bodies['en'] ?? null) }}</textarea>
                <div
                    data-markdown-preview
                    hidden
                    class="min-h-40 rounded-lg border border-hairline-strong bg-surface px-4 py-3 text-sm text-fg [&_a]:underline [&_h1]:mt-4 [&_h1]:text-lg [&_h1]:font-semibold [&_h2]:mt-4 [&_h2]:text-base [&_h2]:font-semibold [&_li]:ml-5 [&_p]:mb-3 [&_ul]:list-disc"
                ></div>
                @error('body.en')
                    <p class="mt-1.5 text-xs text-danger-soft">{{ $message }}</p>
                @enderror
            </div>
        @else
            <details class="mt-2 rounded-lg border border-hairline-strong">
                <summary class="cursor-pointer px-3 py-2 text-sm font-medium text-fg">Body ({{ $label }})</summary>
                <div class="p-3 pt-0" data-markdown-field="{{ route('admin.markdown-preview') }}">
                    <div class="mb-1.5 flex items-center justify-end">
                        <div class="flex items-center gap-1 rounded-lg bg-surface-2 p-1 text-xs font-medium">
                            <button type="button" data-markdown-tab="write" aria-selected="true" class="rounded-md px-2.5 py-1 aria-selected:bg-surface aria-selected:shadow-sm">Write</button>
                            <button type="button" data-markdown-tab="preview" aria-selected="false" class="rounded-md px-2.5 py-1 aria-selected:bg-surface aria-selected:shadow-sm">Preview</button>
                        </div>
                    </div>
                    <textarea id="field-{{ $bodyField }}" name="body[{{ $code }}]" rows="14" class="w-full rounded-lg border border-hairline-strong bg-surface px-3 py-2 font-mono text-sm text-fg focus:border-primary-soft focus:outline-none">{{ old("body.$code", $bodies[$code] ?? null) }}</textarea>
                    <div
                        data-markdown-preview
                        hidden
                        class="min-h-40 rounded-lg border border-hairline-strong bg-surface px-4 py-3 text-sm text-fg [&_a]:underline [&_h1]:mt-4 [&_h1]:text-lg [&_h1]:font-semibold [&_h2]:mt-4 [&_h2]:text-base [&_h2]:font-semibold [&_li]:ml-5 [&_p]:mb-3 [&_ul]:list-disc"
                    ></div>
                </div>
            </details>
        @endif
    @endforeach
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

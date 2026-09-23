@props(['page', 'settings'])

{{--
    Compact "page header" settings panel embedded at the top of a CRUD
    index screen for a page that's a real routed public page (Articles,
    Events, Gallery, Partners, Resources) — edits that page's own
    eyebrow/heading/subtext without a separate nav entry pointing at what
    would otherwise look like a second, different "Articles" screen.
    Shares the same field components/persistence route as the standalone
    per-page settings screens (see admin/settings/edit.blade.php).
--}}
<div class="mb-6 rounded-xl border border-hairline-strong bg-surface p-6">
    <h2 class="font-semibold">Page header</h2>
    <p class="mt-1 text-sm text-muted">Shown at the top of this page on the public site.</p>

    <form method="POST" action="{{ route('admin.settings.update', ['page' => $page]) }}" class="mt-4">
        @csrf
        @method('PUT')

        <div class="grid gap-x-6 gap-y-5 sm:grid-cols-2">
            @foreach ($settings as $setting)
                @php
                    $translations = $setting->translations();
                    $longest = collect($translations)->map(fn ($value) => strlen((string) $value))->max() ?? 0;
                @endphp
                <x-admin.translatable-field
                    :name="'settings['.$setting->key.']'"
                    :label="\Illuminate\Support\Str::headline($setting->key)"
                    :type="$longest > 100 ? 'textarea' : 'text'"
                    :translations="$translations"
                    :class="$longest > 100 ? 'sm:col-span-2' : null"
                />
            @endforeach
        </div>

        <x-ui.button type="submit" size="sm" class="mt-4">Save page header</x-ui.button>
    </form>
</div>

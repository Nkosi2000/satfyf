<x-admin.layout title="Site settings">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @foreach ($settings as $group => $items)
            <div class="rounded-xl border border-hairline-strong bg-surface p-6">
                <h2 class="font-semibold capitalize">{{ $group }}</h2>

                <div class="mt-4 grid gap-5">
                    @foreach ($items as $setting)
                        @php
                            $translations = $setting->translations();
                            $longest = collect($translations)->map(fn ($value) => strlen((string) $value))->max() ?? 0;
                        @endphp
                        <x-admin.translatable-field
                            :name="'settings['.$setting->key.']'"
                            :label="\Illuminate\Support\Str::headline($setting->key)"
                            :type="$longest > 100 ? 'textarea' : 'text'"
                            :translations="$translations"
                        />
                    @endforeach
                </div>
            </div>
        @endforeach

        <x-ui.button type="submit" size="sm">Save settings</x-ui.button>
    </form>
</x-admin.layout>

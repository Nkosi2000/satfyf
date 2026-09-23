<x-admin.layout :title="$pageTitle">
    <form method="POST" action="{{ route('admin.settings.update', ['page' => $page]) }}" class="max-w-6xl space-y-6">
        @csrf
        @method('PUT')

        @php
            $iconOptions = [
                'target' => 'Target',
                'shield' => 'Shield',
                'users' => 'Community',
                'heart' => 'Heart',
                'book' => 'Book',
                'megaphone' => 'Megaphone',
                'leaf' => 'Leaf',
                'flag' => 'Flag',
            ];
        @endphp

        @foreach ($settings as $group => $items)
            <div class="rounded-xl border border-hairline-strong bg-surface p-6">
                <h2 class="font-semibold capitalize">{{ str_replace('_', ' ', $group) }}</h2>

                <div class="mt-4 grid gap-x-6 gap-y-5 sm:grid-cols-2">
                    @foreach ($items as $setting)
                        @php
                            $translations = $setting->translations();
                            $longest = collect($translations)->map(fn ($value) => strlen((string) $value))->max() ?? 0;
                            $isIcon = str_ends_with($setting->key, '_icon');
                        @endphp
                        @if ($isIcon)
                            <x-admin.field
                                :name="'settings['.$setting->key.'][en]'"
                                :label="\Illuminate\Support\Str::headline($setting->key)"
                                type="select"
                                :options="$iconOptions"
                                :value="$translations['en'] ?? 'target'"
                                class="max-w-xs"
                            />
                        @else
                            <x-admin.translatable-field
                                :name="'settings['.$setting->key.']'"
                                :label="\Illuminate\Support\Str::headline($setting->key)"
                                :type="$longest > 100 ? 'textarea' : 'text'"
                                :translations="$translations"
                                :class="$longest > 100 ? 'sm:col-span-2' : null"
                            />
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <x-ui.button type="submit" size="sm">Save settings</x-ui.button>
    </form>
</x-admin.layout>

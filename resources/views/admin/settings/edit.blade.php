<x-admin.layout title="Site settings">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @foreach ($settings as $group => $items)
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="font-semibold capitalize">{{ $group }}</h2>

                <div class="mt-4 grid gap-5">
                    @foreach ($items as $setting)
                        <x-admin.field
                            :name="'settings['.$setting->key.']'"
                            :label="\Illuminate\Support\Str::headline($setting->key)"
                            :type="strlen((string) $setting->value) > 100 ? 'textarea' : 'text'"
                            :value="$setting->value"
                        />
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Save settings</button>
    </form>
</x-admin.layout>

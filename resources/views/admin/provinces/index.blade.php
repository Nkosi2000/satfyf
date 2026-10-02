<x-admin.layout title="Provinces">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-muted">
            {{ $provinces->count() }} {{ Str::plural('province', $provinces->count()) }} · listed under "Youth Chapters" on the Who We Are page, lowest order first.
        </p>
        <x-ui.button href="{{ route('admin.provinces.create') }}" size="sm">Add province</x-ui.button>
    </div>

    @if ($provinces->isEmpty())
        <p class="mt-6 rounded-xl border border-hairline-strong bg-surface p-6 text-sm text-muted">No provinces yet.</p>
    @else
        <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hairline">
                    @foreach ($provinces as $province)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $province->name }}</td>
                            <td class="px-4 py-3 text-muted">{{ $province->order }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.provinces.edit', $province) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                                <form method="POST" action="{{ route('admin.provinces.destroy', $province) }}" class="inline" onsubmit="return confirm('Remove this province?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-3 font-medium text-danger-soft hover:text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-admin.layout>

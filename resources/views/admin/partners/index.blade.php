<x-admin.layout title="Partners">
    <x-admin.page-header-panel page="partners-page" :settings="$pageSettings" />

    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $partners->total() }} partners</p>
        <x-ui.button href="{{ route('admin.partners.create') }}" size="sm">Add partner</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Logo</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($partners as $partner)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($partner->logo_path)
                                <img src="{{ storage_url($partner->logo_path) }}" alt="" class="h-10 w-16 rounded-md bg-cream-raised object-contain p-1" />
                            @else
                                <span class="text-xs text-faint">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $partner->name }}</td>
                        <td class="px-4 py-3"><x-ui.pill-chip>{{ $partner->type->label() }}</x-ui.pill-chip></td>
                        <td class="px-4 py-3">{{ $partner->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="inline" onsubmit="return confirm('Remove this partner?')">
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

    <div class="mt-4">{{ $partners->links() }}</div>
</x-admin.layout>

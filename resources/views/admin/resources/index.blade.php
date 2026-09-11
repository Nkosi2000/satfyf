<x-admin.layout title="Resources">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $resources->total() }} resources</p>
        <x-ui.button href="{{ route('admin.resources.create') }}" size="sm">Upload resource</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($resources as $resource)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $resource->title }}</td>
                        <td class="px-4 py-3 text-muted">{{ $resource->category }}</td>
                        <td class="px-4 py-3">{{ $resource->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.resources.edit', $resource) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.resources.destroy', $resource) }}" class="inline" onsubmit="return confirm('Delete this resource?')">
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

    <div class="mt-4">{{ $resources->links() }}</div>
</x-admin.layout>

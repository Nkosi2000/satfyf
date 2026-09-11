<x-admin.layout title="Events">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $events->total() }} events</p>
        <x-ui.button href="{{ route('admin.events.create') }}" size="sm">Add event</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Starts</th>
                    <th class="px-4 py-3">Featured</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($events as $event)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $event->title }}</td>
                        <td class="px-4 py-3 text-muted">{{ $event->starts_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">{{ $event->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3">{{ $event->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.events.edit', $event) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Delete this event?')">
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

    <div class="mt-4">{{ $events->links() }}</div>
</x-admin.layout>

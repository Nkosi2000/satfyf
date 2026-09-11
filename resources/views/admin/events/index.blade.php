<x-admin.layout title="Events">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $events->total() }} events</p>
        <a href="{{ route('admin.events.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add event</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Starts</th>
                    <th class="px-4 py-3">Featured</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($events as $event)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $event->title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $event->starts_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">{{ $event->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3">{{ $event->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.events.edit', $event) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 font-medium text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $events->links() }}</div>
</x-admin.layout>

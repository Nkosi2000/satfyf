<x-admin.layout title="Resources">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $resources->total() }} resources</p>
        <a href="{{ route('admin.resources.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Upload resource</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($resources as $resource)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $resource->title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $resource->category }}</td>
                        <td class="px-4 py-3">{{ $resource->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.resources.edit', $resource) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.resources.destroy', $resource) }}" class="inline" onsubmit="return confirm('Delete this resource?')">
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

    <div class="mt-4">{{ $resources->links() }}</div>
</x-admin.layout>

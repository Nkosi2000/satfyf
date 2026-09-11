<x-admin.layout title="Partners">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $partners->total() }} partners</p>
        <a href="{{ route('admin.partners.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add partner</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($partners as $partner)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $partner->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $partner->type->label() }}</td>
                        <td class="px-4 py-3">{{ $partner->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="inline" onsubmit="return confirm('Remove this partner?')">
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

    <div class="mt-4">{{ $partners->links() }}</div>
</x-admin.layout>

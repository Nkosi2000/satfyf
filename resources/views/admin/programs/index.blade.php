<x-admin.layout title="Programmes">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $programs->total() }} programmes</p>
        <a href="{{ route('admin.programs.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add programme</a>
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
                @foreach ($programs as $program)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $program->title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $program->category->label() }}</td>
                        <td class="px-4 py-3">{{ $program->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.programs.edit', $program) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" class="inline" onsubmit="return confirm('Remove this programme?')">
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

    <div class="mt-4">{{ $programs->links() }}</div>
</x-admin.layout>

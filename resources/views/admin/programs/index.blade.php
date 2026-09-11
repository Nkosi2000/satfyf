<x-admin.layout title="Programmes">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $programs->total() }} programmes</p>
        <x-ui.button href="{{ route('admin.programs.create') }}" size="sm">Add programme</x-ui.button>
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
                @foreach ($programs as $program)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $program->title }}</td>
                        <td class="px-4 py-3 text-muted">{{ $program->category->label() }}</td>
                        <td class="px-4 py-3">{{ $program->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.programs.edit', $program) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" class="inline" onsubmit="return confirm('Remove this programme?')">
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

    <div class="mt-4">{{ $programs->links() }}</div>
</x-admin.layout>

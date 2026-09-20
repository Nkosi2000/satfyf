<x-admin.layout title="Testimonials">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $testimonials->total() }} testimonials</p>
        <x-ui.button href="{{ route('admin.testimonials.create') }}" size="sm">Add testimonial</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Quote</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($testimonials as $testimonial)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $testimonial->name }}</td>
                        <td class="px-4 py-3 text-muted">{{ $testimonial->role }}</td>
                        <td class="max-w-xs truncate px-4 py-3 text-muted">{{ $testimonial->quote }}</td>
                        <td class="px-4 py-3">{{ $testimonial->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline" onsubmit="return confirm('Remove this testimonial?')">
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

    <div class="mt-4">{{ $testimonials->links() }}</div>
</x-admin.layout>

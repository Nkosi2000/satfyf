<x-admin.layout title="FAQs">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $faqs->total() }} questions</p>
        <x-ui.button href="{{ route('admin.faqs.create') }}" size="sm">Add FAQ</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Question</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($faqs as $faq)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $faq->question }}</td>
                        <td class="px-4 py-3">{{ $faq->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete this FAQ?')">
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

    <div class="mt-4">{{ $faqs->links() }}</div>
</x-admin.layout>

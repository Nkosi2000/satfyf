<x-admin.layout title="FAQs">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $faqs->total() }} questions</p>
        <a href="{{ route('admin.faqs.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add FAQ</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Question</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($faqs as $faq)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $faq->question }}</td>
                        <td class="px-4 py-3">{{ $faq->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete this FAQ?')">
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

    <div class="mt-4">{{ $faqs->links() }}</div>
</x-admin.layout>

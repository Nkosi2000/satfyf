<x-admin.layout title="Contact submissions">
    <p class="text-sm text-slate-500">{{ $submissions->total() }} submissions</p>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($submissions as $submission)
                    <tr class="{{ $submission->is_read ? '' : 'bg-slate-50/60 font-medium' }}">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="hover:underline">{{ $submission->name }}</a>
                            <span class="block text-xs font-normal text-slate-500">{{ $submission->email }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $submission->subject ?: '—' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $submission->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
</x-admin.layout>

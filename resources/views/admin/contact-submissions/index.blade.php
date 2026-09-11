<x-admin.layout title="Contact submissions">
    <p class="text-sm text-muted">{{ $submissions->total() }} submissions</p>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($submissions as $submission)
                    <tr class="{{ $submission->is_read ? '' : 'bg-surface-2/60 font-medium' }}">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="hover:underline">{{ $submission->name }}</a>
                            <span class="block text-xs font-normal text-muted">{{ $submission->email }}</span>
                        </td>
                        <td class="px-4 py-3 text-muted">{{ $submission->subject ?: '—' }}</td>
                        <td class="px-4 py-3 text-muted">{{ $submission->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-danger-soft hover:text-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
</x-admin.layout>

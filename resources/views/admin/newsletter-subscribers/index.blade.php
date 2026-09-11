<x-admin.layout title="Newsletter subscribers">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $subscribers->total() }} subscribers</p>
        <x-ui.button href="{{ route('admin.newsletter-subscribers.export') }}" variant="secondary" size="sm">Export CSV</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Subscribed</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $subscriber->email }}</td>
                        <td class="px-4 py-3 text-muted">{{ $subscriber->subscribed_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" onsubmit="return confirm('Remove this subscriber?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-danger-soft hover:text-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $subscribers->links() }}</div>
</x-admin.layout>

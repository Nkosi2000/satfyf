<x-admin.layout title="Newsletter subscribers">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $subscribers->total() }} subscribers</p>
        <a href="{{ route('admin.newsletter-subscribers.export') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Export CSV</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Subscribed</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $subscriber->email }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $subscriber->subscribed_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" onsubmit="return confirm('Remove this subscriber?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $subscribers->links() }}</div>
</x-admin.layout>

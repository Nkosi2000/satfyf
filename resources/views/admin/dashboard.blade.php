<x-admin.layout title="Dashboard">
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($counts as $label => $count)
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-2xl font-semibold">{{ $count }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold">Recent contact submissions</h2>
                <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-slate-500 hover:text-slate-900">View all &rarr;</a>
            </div>
            <p class="mt-1 text-xs text-slate-400">{{ $unreadCount }} unread</p>

            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($recentSubmissions as $submission)
                    <li class="py-3">
                        <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="block">
                            <p class="text-sm font-medium">{{ $submission->name }}</p>
                            <p class="text-xs text-slate-500">{{ $submission->email }} &middot; {{ $submission->created_at->diffForHumans() }}</p>
                        </a>
                    </li>
                @empty
                    <li class="py-3 text-sm text-slate-500">No submissions yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold">Recent newsletter subscribers</h2>
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="text-sm text-slate-500 hover:text-slate-900">View all &rarr;</a>
            </div>

            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($recentSubscribers as $subscriber)
                    <li class="py-3">
                        <p class="text-sm font-medium">{{ $subscriber->email }}</p>
                        <p class="text-xs text-slate-500">{{ $subscriber->subscribed_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="py-3 text-sm text-slate-500">No subscribers yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-admin.layout>

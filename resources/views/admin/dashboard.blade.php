<x-admin.layout title="Dashboard">
    @if ($storageUrlWarmStale)
        <div class="mb-6 rounded-lg border border-hairline-strong bg-primary/10 px-4 py-3 text-sm text-primary">
            <p class="font-medium">Storage URL cache hasn't refreshed recently.</p>
            <p class="mt-1 text-primary/80">
                @if ($storageUrlWarmLastRun)
                    Last successful run was {{ $storageUrlWarmLastRun->diffForHumans() }} ({{ $storageUrlWarmLastRun->format('d M Y, H:i') }}).
                @else
                    <code>php artisan app:warm-storage-urls</code> has never completed successfully in this environment.
                @endif
                It's scheduled hourly — if the scheduler (cron calling <code>schedule:run</code> every minute, or the
                Laravel Cloud scheduler) has stopped running, public pages with many images risk timing out the way
                the home page did on 22 September 2026.
            </p>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($counts as $label => $count)
            <div class="rounded-xl border border-hairline-strong bg-surface p-5">
                <p class="text-2xl font-semibold">{{ $count }}</p>
                <p class="mt-1 text-sm text-muted">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-hairline-strong bg-surface p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold">Recent contact submissions</h2>
                <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-muted hover:text-fg">View all &rarr;</a>
            </div>
            <p class="mt-1 text-xs text-faint">{{ $unreadCount }} unread</p>

            <ul class="mt-4 divide-y divide-hairline">
                @forelse ($recentSubmissions as $submission)
                    <li class="py-3">
                        <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="block">
                            <p class="text-sm font-medium">{{ $submission->name }}</p>
                            <p class="text-xs text-muted">{{ $submission->email }} &middot; {{ $submission->created_at->diffForHumans() }}</p>
                        </a>
                    </li>
                @empty
                    <li class="py-3 text-sm text-muted">No submissions yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-hairline-strong bg-surface p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold">Recent newsletter subscribers</h2>
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="text-sm text-muted hover:text-fg">View all &rarr;</a>
            </div>

            <ul class="mt-4 divide-y divide-hairline">
                @forelse ($recentSubscribers as $subscriber)
                    <li class="py-3">
                        <p class="text-sm font-medium">{{ $subscriber->email }}</p>
                        <p class="text-xs text-muted">{{ $subscriber->subscribed_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="py-3 text-sm text-muted">No subscribers yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-admin.layout>

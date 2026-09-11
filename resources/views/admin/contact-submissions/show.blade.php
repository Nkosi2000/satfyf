<x-admin.layout title="Contact submission">
    <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-muted hover:text-fg">&larr; All submissions</a>

    <div class="mt-4 max-w-2xl rounded-xl border border-hairline-strong bg-surface p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-semibold">{{ $submission->subject ?: 'No subject' }}</h2>
                <p class="mt-1 text-sm text-muted">
                    {{ $submission->name }} &middot; <a href="mailto:{{ $submission->email }}" class="hover:underline">{{ $submission->email }}</a>
                    @if ($submission->phone)
                        &middot; {{ $submission->phone }}
                    @endif
                </p>
            </div>
            <p class="text-xs text-faint">{{ $submission->created_at->format('d M Y, H:i') }}</p>
        </div>

        <p class="mt-5 whitespace-pre-line text-sm text-fg">{{ $submission->message }}</p>

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button href="mailto:{{ $submission->email }}" size="sm">Reply by email</x-ui.button>
            <form method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-medium text-danger-soft hover:text-danger">Delete</button>
            </form>
        </div>
    </div>
</x-admin.layout>

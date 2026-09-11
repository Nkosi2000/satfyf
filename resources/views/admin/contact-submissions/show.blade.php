<x-admin.layout title="Contact submission">
    <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-slate-500 hover:text-slate-900">&larr; All submissions</a>

    <div class="mt-4 max-w-2xl rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-semibold">{{ $submission->subject ?: 'No subject' }}</h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $submission->name }} &middot; <a href="mailto:{{ $submission->email }}" class="hover:underline">{{ $submission->email }}</a>
                    @if ($submission->phone)
                        &middot; {{ $submission->phone }}
                    @endif
                </p>
            </div>
            <p class="text-xs text-slate-400">{{ $submission->created_at->format('d M Y, H:i') }}</p>
        </div>

        <p class="mt-5 whitespace-pre-line text-sm text-slate-700">{{ $submission->message }}</p>

        <div class="mt-6 flex items-center gap-3">
            <a href="mailto:{{ $submission->email }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Reply by email</a>
            <form method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">Delete</button>
            </form>
        </div>
    </div>
</x-admin.layout>

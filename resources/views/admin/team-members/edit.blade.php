<x-admin.layout title="Edit team member">
    <form method="POST" action="{{ route('admin.team-members.update', $teamMember) }}" enctype="multipart/form-data" class="max-w-2xl rounded-xl border border-hairline-strong bg-surface p-6">
        @csrf
        @method('PUT')
        @include('admin.team-members._form')

        <div class="mt-6 flex items-center gap-3">
            <x-ui.button type="submit" size="sm">Save changes</x-ui.button>
            <a href="{{ route('admin.team-members.index') }}" class="text-sm text-muted hover:text-fg">Cancel</a>
        </div>
    </form>
</x-admin.layout>

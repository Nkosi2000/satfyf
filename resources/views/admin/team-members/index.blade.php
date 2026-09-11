<x-admin.layout title="Team">
    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $teamMembers->total() }} team members</p>
        <x-ui.button href="{{ route('admin.team-members.create') }}" size="sm">Add team member</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($teamMembers as $member)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $member->name }}</td>
                        <td class="px-4 py-3 text-muted">{{ $member->role }}</td>
                        <td class="px-4 py-3">{{ $member->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.team-members.edit', $member) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.team-members.destroy', $member) }}" class="inline" onsubmit="return confirm('Remove this team member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 font-medium text-danger-soft hover:text-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $teamMembers->links() }}</div>
</x-admin.layout>

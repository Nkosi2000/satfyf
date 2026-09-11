<x-admin.layout title="Team">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $teamMembers->total() }} team members</p>
        <a href="{{ route('admin.team-members.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Add team member</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Published</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($teamMembers as $member)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $member->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $member->role }}</td>
                        <td class="px-4 py-3">{{ $member->published ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.team-members.edit', $member) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.team-members.destroy', $member) }}" class="inline" onsubmit="return confirm('Remove this team member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 font-medium text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $teamMembers->links() }}</div>
</x-admin.layout>

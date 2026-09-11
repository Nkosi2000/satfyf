<x-admin.layout title="Articles">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $articles->total() }} articles</p>
        <a href="{{ route('admin.articles.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Write article</a>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Author</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($articles as $article)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $article->title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $article->author_name }}</td>
                        <td class="px-4 py-3">
                            @if ($article->published_at?->isPast())
                                <span class="text-emerald-600">Published</span>
                            @elseif ($article->published_at)
                                <span class="text-amber-600">Scheduled</span>
                            @else
                                <span class="text-slate-400">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="inline" onsubmit="return confirm('Delete this article?')">
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

    <div class="mt-4">{{ $articles->links() }}</div>
</x-admin.layout>

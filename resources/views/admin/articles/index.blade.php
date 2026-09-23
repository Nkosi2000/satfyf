<x-admin.layout title="Articles">
    <x-admin.page-header-panel page="articles-page" :settings="$pageSettings" />

    <div class="flex items-center justify-between">
        <p class="text-sm text-muted">{{ $articles->total() }} articles</p>
        <x-ui.button href="{{ route('admin.articles.create') }}" size="sm">Write article</x-ui.button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-hairline-strong bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-hairline-strong bg-surface-2 text-xs uppercase tracking-wide text-muted">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Author</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @foreach ($articles as $article)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $article->title }}</td>
                        <td class="px-4 py-3 text-muted">{{ $article->author_name }}</td>
                        <td class="px-4 py-3">
                            @if ($article->published_at?->isPast())
                                <span class="text-primary">Published</span>
                            @elseif ($article->published_at)
                                <span class="text-secondary">Scheduled</span>
                            @else
                                <span class="text-faint">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="font-medium text-muted hover:text-fg">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="inline" onsubmit="return confirm('Delete this article?')">
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

    <div class="mt-4">{{ $articles->links() }}</div>
</x-admin.layout>

<x-layouts.app :title="__('Articles')">
    <x-ui.page-hero eyebrow="{{ __('Articles') }}" subtext="{{ __('Fact-checked coverage of tobacco harm, industry tactics and policy — plus the campaigns, chapters and young people driving the response.') }}">
        {{ __('Reporting, explainers and stories.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="reveal-stagger grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="group block">
                    <div class="aspect-[16/10] overflow-hidden rounded-2xl border border-hairline bg-surface">
                        @if ($article->cover_image_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        @endif
                    </div>
                    <p class="mt-4 text-xs text-faint">{{ $article->published_at->translatedFormat('d M Y') }}</p>
                    <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $article->title }}</p>
                    <p class="mt-1 text-sm text-muted">{{ $article->excerpt }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-12">{{ $articles->links('vendor.pagination.satfyf') }}</div>
    </x-ui.section>
</x-layouts.app>

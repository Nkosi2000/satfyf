<x-layouts.app :title="__('Articles')">
    @php
        $featuredArticle = $articles->first(fn ($article) => $article->cover_image_path);
    @endphp

    <x-ui.page-hero :eyebrow="__('Articles')" :subtext="__('Fact-checked coverage of tobacco harm, industry tactics and policy — plus the campaigns, chapters and young people driving the response.')">
        {{ __('Reporting, explainers and stories.') }}

        <x-slot:image>
            @if ($featuredArticle)
                <img
                    src="{{ storage_url($featuredArticle->cover_image_path) }}"
                    alt=""
                    class="aspect-4/5 w-full rounded-2xl object-cover"
                    style="box-shadow: var(--shadow-soft)"
                />
            @else
                <x-ui.brand-hero-image />
            @endif
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="magazine-grid reveal-stagger">
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="group block">
                    <div class="aspect-[16/10] overflow-hidden rounded-xl bg-surface-2">
                        @if ($article->cover_image_path)
                            <img src="{{ storage_url($article->cover_image_path) }}" alt="" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        @endif
                    </div>
                    <p class="mt-5 text-xs font-bold text-faint uppercase">{{ $article->published_at->translatedFormat('d M Y') }}</p>
                    <p class="mt-2 text-xl leading-snug font-black text-fg group-hover:text-primary-soft">{{ $article->title }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-muted">{{ $article->excerpt }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-12">{{ $articles->links('vendor.pagination.satfyf') }}</div>
    </x-ui.section>
</x-layouts.app>

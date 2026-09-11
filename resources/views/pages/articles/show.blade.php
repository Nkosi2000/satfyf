<x-layouts.app :title="$article->title" :description="$article->excerpt">
    <article class="pt-20 pb-24 sm:pt-28">
        <x-ui.section width="narrow" class="!py-0">
            <a href="{{ route('articles.index') }}" class="text-sm text-muted hover:text-cream">&larr; All articles</a>

            <p class="mt-6 text-xs text-faint">{{ $article->published_at->format('d M Y') }} @if ($article->author_name) &middot; {{ $article->author_name }} @endif</p>
            <h1 class="mt-3 text-balance font-serif text-4xl leading-[1.1] text-cream sm:text-5xl">{{ $article->title }}</h1>

            @if ($article->cover_image_path)
                <div class="mt-8 aspect-[16/9] overflow-hidden rounded-2xl border border-hairline">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="" class="h-full w-full object-cover" />
                </div>
            @endif

            <div class="mt-10 max-w-2xl space-y-5 text-base leading-relaxed text-muted [&_a]:text-ember-soft [&_a]:underline [&_h2]:mt-8 [&_h2]:font-serif [&_h2]:text-2xl [&_h2]:text-cream [&_strong]:text-cream">
                {!! $article->renderedBody() !!}
            </div>
        </x-ui.section>

        @if ($related->isNotEmpty())
            <x-ui.section class="hairline-t mt-20" width="wide">
                <x-ui.section-header eyebrow="Keep Reading">More articles.</x-ui.section-header>
                <div class="mt-8 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('articles.show', $item) }}" class="group block">
                            <p class="text-xs text-faint">{{ $item->published_at->format('d M Y') }}</p>
                            <p class="mt-2 font-medium text-cream group-hover:text-ember-soft">{{ $item->title }}</p>
                        </a>
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    </article>
</x-layouts.app>

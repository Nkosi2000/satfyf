<x-layouts.app :title="$article->title" :description="$article->excerpt">
    <article class="pt-24 pb-24 sm:pt-32">
        <x-ui.section width="wide" class="!py-0">
            <a href="{{ route('articles.index') }}" class="text-sm text-muted hover:text-fg">&larr; {{ __('All articles') }}</a>

            <div class="hero-enter">
                <p class="mt-6 text-xs text-faint">{{ $article->published_at->translatedFormat('d M Y') }} @if ($article->author_name) &middot; {{ $article->author_name }} @endif</p>
                <h1 class="mt-3 text-balance text-4xl leading-[1.1] text-fg sm:text-5xl">{{ $article->title }}</h1>
            </div>

            @if ($article->cover_image_path)
                <div class="mt-8 aspect-[16/9] overflow-hidden rounded-2xl border border-hairline">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="" class="h-full w-full object-cover" />
                </div>
            @endif

            <div class="mt-10 max-w-2xl space-y-5 text-base leading-relaxed text-muted [&_a]:text-primary-soft [&_a]:underline [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:text-fg [&_img]:w-full [&_img]:rounded-2xl [&_img]:border [&_img]:border-hairline [&_strong]:text-fg">
                {!! $article->renderedBody() !!}
            </div>

            @if ($article->attachment_path)
                <div class="mt-8 max-w-2xl">
                    <x-ui.button href="{{ route('articles.attachment', $article) }}" variant="secondary">
                        {{ __('Download attachment') }}
                        @if ($article->attachment_name)
                            <span class="text-faint">&middot; {{ $article->attachment_name }}</span>
                        @endif
                    </x-ui.button>
                </div>
            @endif

            @if ($article->images->isNotEmpty())
                <div class="reveal-stagger mt-10 grid max-w-2xl grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($article->images as $image)
                        <div class="hover-zoom aspect-square overflow-hidden rounded-xl border border-hairline">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                                alt=""
                                loading="lazy"
                                class="h-full w-full object-cover"
                            />
                        </div>
                    @endforeach
                </div>
            @endif
        </x-ui.section>

        @if ($related->isNotEmpty())
            <x-ui.section class="hairline-t mt-20" width="wide">
                <x-ui.section-header eyebrow="{{ __('Keep Reading') }}">{{ __('More articles.') }}</x-ui.section-header>
                <div class="reveal-stagger mt-8 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('articles.show', $item) }}" class="group glass-row block py-3 hover:glass">
                            <p class="text-xs text-faint">{{ $item->published_at->translatedFormat('d M Y') }}</p>
                            <p class="mt-2 font-medium text-fg group-hover:text-primary-soft">{{ $item->title }}</p>
                        </a>
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    </article>
</x-layouts.app>

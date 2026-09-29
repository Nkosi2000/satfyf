@props(['testimonial'])

<figure {{ $attributes->class(['card-soft flex flex-col gap-5 p-7']) }}>
    <span class="text-5xl leading-none font-black text-primary-soft" aria-hidden="true">&ldquo;</span>
    <blockquote class="flex-1 text-lg leading-relaxed text-balance text-fg sm:text-xl">{{ $testimonial->quote }}</blockquote>
    <figcaption class="flex items-center gap-3 border-t border-hairline pt-4">
        @if ($testimonial->photo_path)
            <img src="{{ storage_url($testimonial->photo_path) }}" alt="" class="h-11 w-11 shrink-0 rounded-full object-cover" />
        @else
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-surface-2 text-sm font-black text-fg">
                {{ \Illuminate\Support\Str::of($testimonial->name)->explode(' ')->map(fn ($n) => $n[0])->join('') }}
            </span>
        @endif
        <div>
            <p class="text-base font-black text-fg">{{ $testimonial->name }}</p>
            @if ($testimonial->role)
                <p class="text-xs font-bold text-muted uppercase">{{ $testimonial->role }}</p>
            @endif
        </div>
    </figcaption>
</figure>

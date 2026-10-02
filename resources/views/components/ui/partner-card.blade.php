@props(['partner'])

{{-- Square fade-flip card: the front shows the logo, name and role; hover
     (or focus — tapping it on touch screens, or tabbing to it) fades in the
     back with the description and a "Visit" link. tabindex makes the card
     itself focusable so touch and keyboard users can reveal the back. --}}
<div
    tabindex="0"
    {{ $attributes->class(['group relative aspect-square overflow-hidden rounded-2xl border border-hairline bg-surface outline-none focus-visible:ring-2 focus-visible:ring-primary-soft']) }}
    style="box-shadow: var(--shadow-soft-sm)"
>
    <div class="absolute inset-0 flex flex-col items-center justify-center gap-5 p-8 text-center transition-opacity duration-500 ease-out group-focus-within:opacity-0 group-hover:opacity-0">
        @if ($partner->logo_path)
            <img src="{{ storage_url($partner->logo_path) }}" alt="" loading="lazy" class="h-28 w-full max-w-[14rem] object-contain" />
        @else
            <span class="flex h-24 w-24 items-center justify-center rounded-full bg-surface-2 text-3xl font-bold text-fg">
                {{ \Illuminate\Support\Str::of($partner->name)->explode(' ')->take(2)->map(fn ($word) => \Illuminate\Support\Str::upper($word[0]))->join('') }}
            </span>
        @endif
        <h3 class="text-2xl font-bold text-fg">{{ $partner->name }}</h3>
        @if ($partner->role)
            <x-ui.pill-chip>{{ $partner->role }}</x-ui.pill-chip>
        @endif
    </div>

    <div
        class="absolute inset-0 flex flex-col items-center justify-center gap-6 p-8 text-center text-on-accent opacity-0 transition-opacity duration-500 ease-out group-focus-within:opacity-100 group-hover:opacity-100"
        style="background-image: linear-gradient(150deg, var(--color-primary-deep) 0%, var(--color-primary) 100%)"
    >
        <p class="text-lg leading-relaxed line-clamp-7">{{ $partner->description ?: ($partner->role ?: $partner->name) }}</p>
        @if ($partner->url)
            <a
                href="{{ $partner->url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="rounded-full border border-current px-5 py-2 text-sm font-bold transition-colors hover:bg-on-accent hover:text-primary-deep"
            >
                {{ __('Visit :name', ['name' => $partner->name]) }}
            </a>
        @endif
    </div>
</div>

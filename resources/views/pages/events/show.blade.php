<x-layouts.app :title="$event->title">
    <article class="pt-24 pb-24 sm:pt-32">
        <x-ui.section width="wide" class="!py-0">
            <a href="{{ route('events.index') }}" class="text-sm text-muted hover:text-fg">&larr; {{ __('All events') }}</a>

            <div class="hero-enter">
                <x-ui.eyebrow class="mt-6">{{ $event->isUpcoming() ? __('Upcoming') : __('Past Event') }}</x-ui.eyebrow>
                <h1 class="mt-3 text-balance text-4xl leading-[1.1] text-fg sm:text-5xl">{{ $event->title }}</h1>

                <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-2 text-sm text-muted">
                    <div>
                        <dt class="text-faint">{{ __('When') }}</dt>
                        <dd class="text-fg">{{ $event->starts_at->translatedFormat('d M Y, H:i') }}</dd>
                    </div>
                    @if ($event->location)
                        <div>
                            <dt class="text-faint">{{ __('Where') }}</dt>
                            <dd class="text-fg">{{ $event->location }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if ($event->cover_image_path)
                <div class="mt-8 aspect-[16/9] overflow-hidden rounded-2xl border border-hairline">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($event->cover_image_path) }}" alt="" class="h-full w-full object-cover" />
                </div>
            @endif

            <p class="mt-10 max-w-2xl whitespace-pre-line text-base leading-relaxed text-muted">{{ $event->description }}</p>

            @if ($event->isUpcoming())
                <div class="mt-10">
                    <x-ui.button href="{{ route('contact') }}" size="lg">{{ __('RSVP or ask a question') }}</x-ui.button>
                </div>
            @endif
        </x-ui.section>
    </article>
</x-layouts.app>

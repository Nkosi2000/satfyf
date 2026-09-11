<x-layouts.app :title="__('Events')">
    <section class="pt-24 pb-20 sm:pt-32">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>{{ __('Events') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">{{ __('Where to find us next.') }}</h1>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t">
        <x-ui.section-header eyebrow="{{ __('Upcoming') }}">{{ __('Join us.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 hairline-t">
            @forelse ($upcoming as $event)
                <a href="{{ route('events.show', $event) }}" class="group flex flex-col gap-2 py-6 hairline-b sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-medium text-fg group-hover:text-primary-soft">{{ $event->title }}</p>
                        <p class="mt-1 text-sm text-muted">{{ $event->location }}</p>
                    </div>
                    <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }}</p>
                </a>
            @empty
                <p class="py-6 text-sm text-muted">{{ __('No upcoming events right now — check back soon.') }}</p>
            @endforelse
        </div>
    </x-ui.section>

    @if ($past->isNotEmpty())
        <x-ui.section class="hairline-t">
            <x-ui.section-header eyebrow="{{ __('Past') }}">{{ __("Where we've been.") }}</x-ui.section-header>
            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($past as $event)
                    <a href="{{ route('events.show', $event) }}" class="group flex flex-col gap-2 py-6 hairline-b sm:flex-row sm:items-center sm:justify-between">
                        <p class="font-medium text-muted group-hover:text-fg">{{ $event->title }}</p>
                        <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $past->links('vendor.pagination.satfyf') }}</div>
        </x-ui.section>
    @endif
</x-layouts.app>

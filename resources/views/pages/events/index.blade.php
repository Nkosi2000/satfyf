<x-layouts.app :title="__('Events')">
    <x-ui.page-hero :eyebrow="__('Events')" :subtext="__('Think sessions, school visits, public demonstrations and Community Imbizos happening across the country — open to any young person, school or community group who wants to take part.')">
        {{ __('Where to find us next.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="__('Upcoming')">{{ __('Join us.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 hairline-t">
            @forelse ($upcoming as $event)
                <a href="{{ route('events.show', $event) }}" class="group glass-row flex flex-col gap-2 py-6 hairline-b hover:glass sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-medium text-fg group-hover:text-primary-soft">{{ $event->title }}</p>
                        <p class="mt-1 text-sm text-muted">{{ $event->location }}</p>
                    </div>
                    <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }}</p>
                </a>
            @empty
                <x-ui.empty-state>{{ __('No upcoming events right now — check back soon.') }}</x-ui.empty-state>
            @endforelse
        </div>
    </x-ui.section>

    @if ($past->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header :eyebrow="__('Past')">{{ __("Where we've been.") }}</x-ui.section-header>
            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($past as $event)
                    <a href="{{ route('events.show', $event) }}" class="group glass-row flex flex-col gap-2 py-6 hairline-b hover:glass sm:flex-row sm:items-center sm:justify-between">
                        <p class="font-medium text-muted group-hover:text-fg">{{ $event->title }}</p>
                        <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $past->links('vendor.pagination.satfyf') }}</div>
        </x-ui.section>
    @endif
</x-layouts.app>

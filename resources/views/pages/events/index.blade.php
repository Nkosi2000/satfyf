<x-layouts.app :title="$content['events_page_hero_eyebrow'] ?? __('Events')">
    @php
        $featuredEvent = $upcoming->first(fn ($event) => $event->cover_image_path);
    @endphp

    <x-ui.page-hero :eyebrow="$content['events_page_hero_eyebrow'] ?? __('Events')" :subtext="$content['events_page_hero_subtext'] ?? __('Think sessions, school visits, public demonstrations and Community Imbizos happening across the country — open to any young person, school or community group who wants to take part.')">
        {{ $content['events_page_hero_heading'] ?? __('Where to find us next.') }}

        <x-slot:image>
            @if ($featuredEvent)
                <img
                    src="{{ storage_url($featuredEvent->cover_image_path) }}"
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
        <x-ui.section-header :eyebrow="__('Upcoming')">{{ __('Join us.') }}</x-ui.section-header>
        <div class="reveal-stagger mt-8 hairline-t">
            @forelse ($upcoming as $event)
                <x-ui.link-row :href="route('events.show', $event)" class="flex flex-col gap-2 py-6 hairline-b sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <x-ui.row-title>{{ $event->title }}</x-ui.row-title>
                        <p class="mt-1 text-sm text-muted">{{ $event->location }}</p>
                    </div>
                    <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y, H:i') }}</p>
                </x-ui.link-row>
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
                    <x-ui.link-row :href="route('events.show', $event)" class="flex flex-col gap-2 py-6 hairline-b sm:flex-row sm:items-center sm:justify-between">
                        <x-ui.row-title muted>{{ $event->title }}</x-ui.row-title>
                        <p class="text-sm text-faint">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                    </x-ui.link-row>
                @endforeach
            </div>
            <div class="mt-8">{{ $past->links('vendor.pagination.satfyf') }}</div>
        </x-ui.section>
    @endif
</x-layouts.app>

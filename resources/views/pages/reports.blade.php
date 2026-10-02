<x-layouts.app :title="$content['reports_hero_eyebrow'] ?? __('Reports & Publications')">
    <x-ui.page-hero :eyebrow="$content['reports_hero_eyebrow'] ?? __('Reports & Publications')" :subtext="$content['reports_hero_subtext'] ?? null">
        {{ $content['reports_hero_heading'] ?? __('Our work, on the record.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header wide :eyebrow="$content['reports_list_eyebrow'] ?? __('Publications')">{{ $content['reports_list_heading'] ?? __('Read and download.') }}</x-ui.section-header>

        @if ($reports->isNotEmpty())
            <div class="reveal-stagger mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($reports as $report)
                    <x-ui.info-card :title="$report['title']" :href="$report['url'] ?: null" :link-label="__('Read')" external>{{ $report['body'] }}</x-ui.info-card>
                @endforeach
            </div>
        @else
            <x-ui.empty-state class="mt-8">{{ __('Publications will be listed here soon.') }}</x-ui.empty-state>
        @endif
    </x-ui.section>
</x-layouts.app>

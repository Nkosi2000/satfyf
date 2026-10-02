<x-layouts.app :title="$partnerSettings['partners_hero_eyebrow'] ?? __('Partners & Collaborative')">
    <x-ui.page-hero :eyebrow="$partnerSettings['partners_hero_eyebrow'] ?? __('Partners & Collaborative')" :subtext="$partnerSettings['partners_hero_subtext'] ?? __('Schools, health organisations, government departments and community groups who share the venues, the credibility and the reach it takes to put tobacco-free choices in front of more young people.')">
        {{ $partnerSettings['partners_hero_heading'] ?? __("We don't do this alone.") }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @foreach ($types as $type)
        @if ($partners->has($type->value))
            <x-ui.section class="hairline-t" width="wide">
                <x-ui.section-header :eyebrow="$type->label()">
                    {{ trans_choice(':count organisation|:count organisations', $partners[$type->value]->count(), ['count' => $partners[$type->value]->count()]) }}
                </x-ui.section-header>
                @if ($type === App\Enums\PartnerType::AdvisoryCouncil && ! empty($partnerSettings['advisory_council_intro']))
                    <x-ui.lead class="mt-4">{{ $partnerSettings['advisory_council_intro'] }}</x-ui.lead>
                @endif
                <div class="reveal-stagger mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners[$type->value] as $partner)
                        <x-ui.partner-card :partner="$partner" />
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    @endforeach
</x-layouts.app>

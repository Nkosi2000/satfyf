<x-layouts.app :title="$content['why_we_exist_hero_eyebrow'] ?? __('Why We Exist')">
    <x-ui.page-hero :eyebrow="$content['why_we_exist_hero_eyebrow'] ?? __('Why We Exist')" :subtext="$content['why_we_exist_hero_subtext'] ?? __('Tobacco use carries real health harms, real economic costs, and it still starts young. In a country still building the policy and enforcement to protect its youth, silence isn\'t neutral — it\'s a gap the industry is glad to fill.')">
        {{ $content['why_we_exist_hero_heading'] ?? __("Tobacco doesn't market itself to adults.") }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        @php
            $stats = collect([1, 2, 3])->map(fn ($i) => [
                'label' => $content['why_we_exist_stat_'.$i.'_label'] ?? '',
                'body' => $content['why_we_exist_stat_'.$i.'_body'] ?? '',
            ]);
        @endphp
        <div class="reveal-stagger grid gap-10 sm:grid-cols-3">
            @foreach ($stats as $stat)
                <div>
                    <p class="text-3xl font-black text-primary-soft">{{ $stat['label'] }}</p>
                    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $stat['body'] }}</p>
                </div>
            @endforeach
        </div>
    </x-ui.section>

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="$content['why_we_exist_respond_eyebrow'] ?? __('How We Respond')">
            {{ $content['why_we_exist_respond_heading'] ?? __("We don't just warn. We show up.") }}
        </x-ui.section-header>
        <p class="mt-6 text-balance text-lg leading-relaxed text-muted sm:text-xl">
            {{ $content['why_we_exist_respond_body'] ?? __('Think sessions, social media conversations, media advocacy, public demonstrations and Community Imbizos — SATFYF meets young people in the spaces they already occupy, with facts instead of fear.') }}
        </p>
        <div class="mt-8">
            <x-ui.button href="{{ route('what-we-do') }}" variant="secondary">{{ __('See how we work') }}</x-ui.button>
        </div>
    </x-ui.section>
</x-layouts.app>

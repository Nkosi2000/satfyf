<x-layouts.app :title="$content['quit_support_hero_eyebrow'] ?? __('Quit Support')">
    <x-ui.page-hero :eyebrow="$content['quit_support_hero_eyebrow'] ?? __('Quit Support')" :subtext="$content['quit_support_hero_subtext'] ?? null">
        {{ $content['quit_support_hero_heading'] ?? __("Ready to quit? You don't have to do it alone.") }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @if ($steps->isNotEmpty())
        <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
            <x-ui.section-header wide :eyebrow="$content['quit_support_steps_eyebrow'] ?? __('Where to start')">{{ $content['quit_support_steps_heading'] ?? __('Small steps that work.') }}</x-ui.section-header>
            <div class="reveal-stagger mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($steps as $step)
                    <x-ui.info-card :title="$loop->iteration.'. '.$step['title']">{{ $step['body'] }}</x-ui.info-card>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section id="contact-form" class="section-divider" width="wide" triangles="bottom-left">
        <x-ui.section-header wide :eyebrow="$content['quit_support_help_eyebrow'] ?? __('Talk to someone')">{{ $content['quit_support_help_heading'] ?? __('Help is available.') }}</x-ui.section-header>
        @if (! empty($content['quit_support_help_body']))
            <x-ui.lead wide class="mt-4">{{ $content['quit_support_help_body'] }}</x-ui.lead>
        @endif

        @if ($helplines->isNotEmpty())
            <x-ui.detail-list
                class="mt-8 max-w-3xl"
                :items="$helplines->map(fn ($helpline) => ['label' => $helpline['name'], 'value' => $helpline['contact']])"
            />
        @endif

        <x-contact-form :subject="__('Quit support')" class="mt-10" />
    </x-ui.section>
</x-layouts.app>

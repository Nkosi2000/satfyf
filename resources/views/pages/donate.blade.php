<x-layouts.app :title="$content['donate_hero_eyebrow'] ?? __('Donate')">
    <x-ui.page-hero :eyebrow="$content['donate_hero_eyebrow'] ?? __('Donate')" :subtext="$content['donate_hero_subtext'] ?? null">
        {{ $content['donate_hero_heading'] ?? __('Fund a tobacco-free generation.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @if ($impacts->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header wide :eyebrow="$content['donate_impact_eyebrow'] ?? __('Your impact')">{{ $content['donate_impact_heading'] ?? __('Where your support goes.') }}</x-ui.section-header>
            <div class="reveal-stagger mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($impacts as $impact)
                    <x-ui.info-card :title="$impact['title']">{{ $impact['body'] }}</x-ui.info-card>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    @php
        $bankDetails = [
            ['label' => __('Account name'), 'value' => $content['donate_bank_account_name'] ?? null],
            ['label' => __('Bank'), 'value' => $content['donate_bank_name'] ?? null],
            ['label' => __('Account number'), 'value' => $content['donate_bank_account_number'] ?? null],
            ['label' => __('Branch code'), 'value' => $content['donate_bank_branch_code'] ?? null],
            ['label' => __('Reference'), 'value' => $content['donate_bank_reference'] ?? null],
        ];
    @endphp

    @if (filled($content['donate_bank_account_number'] ?? null))
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header wide :eyebrow="$content['donate_bank_eyebrow'] ?? __('Banking details')">{{ $content['donate_bank_heading'] ?? __('Give by EFT.') }}</x-ui.section-header>
            <x-ui.detail-list class="mt-8 max-w-3xl" :items="$bankDetails" />
        </x-ui.section>
    @endif

    <x-ui.section id="contact-form" class="hairline-t" width="wide">
        <x-ui.section-header wide :eyebrow="$content['donate_form_eyebrow'] ?? __('Partner with us')">{{ $content['donate_form_heading'] ?? __('Other ways to give.') }}</x-ui.section-header>
        <x-contact-form :subject="__('Donations and sponsorship')" class="mt-8" />
    </x-ui.section>
</x-layouts.app>

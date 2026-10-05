<x-layouts.app :title="$content['media_hero_eyebrow'] ?? __('Media & Press')">
    <x-ui.page-hero :eyebrow="$content['media_hero_eyebrow'] ?? __('Media & Press')" :subtext="$content['media_hero_subtext'] ?? null">
        {{ $content['media_hero_heading'] ?? __('For journalists and media.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section id="contact-form" class="section-divider" width="wide" triangles="bottom-right">
        <x-ui.section-header wide :eyebrow="$content['media_contact_eyebrow'] ?? __('Press enquiries')">{{ $content['media_contact_heading'] ?? __('Talk to our media team.') }}</x-ui.section-header>
        @if (! empty($content['media_contact_body']))
            <x-ui.lead wide class="mt-4">{{ $content['media_contact_body'] }}</x-ui.lead>
        @endif

        <x-ui.detail-list
            class="mt-8 max-w-3xl"
            :items="[
                ['label' => __('Contact'), 'value' => $content['media_contact_name'] ?? null],
                ['label' => __('Email'), 'value' => $content['media_contact_email'] ?? null, 'href' => 'mailto:'.($content['media_contact_email'] ?? '')],
                ['label' => __('Phone'), 'value' => $content['media_contact_phone'] ?? null, 'href' => 'tel:'.preg_replace('/[^\d+]/', '', $content['media_contact_phone'] ?? '')],
            ]"
        />

        <x-contact-form :subject="__('Media enquiry')" class="mt-10" />
    </x-ui.section>

    @if ($articles->isNotEmpty())
        <x-ui.section class="section-divider" width="wide" triangles="bottom-left">
            <div class="flex items-end justify-between gap-4">
                <x-ui.section-header wide :eyebrow="$content['media_news_eyebrow'] ?? __('Latest news')">{{ $content['media_news_heading'] ?? __('Recent stories.') }}</x-ui.section-header>
                <a href="{{ route('articles.index') }}" class="shrink-0 text-sm text-muted hover:text-fg">{{ __('View all') }} &rarr;</a>
            </div>
            <div class="reveal-stagger mt-8 hairline-t">
                @foreach ($articles as $article)
                    <x-ui.link-row :href="route('articles.show', $article)" class="block py-6 hairline-b">
                        <p class="text-xs text-faint">{{ $article->published_at->translatedFormat('d M Y') }}</p>
                        <x-ui.row-title class="mt-2">{{ $article->title }}</x-ui.row-title>
                    </x-ui.link-row>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <x-ui.section-header :eyebrow="$content['media_brand_eyebrow'] ?? __('Brand assets')">{{ $content['media_brand_heading'] ?? __('Our logo.') }}</x-ui.section-header>
                @if (! empty($content['media_brand_body']))
                    <x-ui.lead class="mt-4">{{ $content['media_brand_body'] }}</x-ui.lead>
                @endif
                <x-ui.button :href="asset('images/250px-by-100px-SATFYF-LOGO.jpg')" download class="mt-8">{{ __('Download logo') }}</x-ui.button>
            </div>
            <img src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}" alt="SATFYF" class="w-full max-w-xl rounded-[2rem]" style="box-shadow: var(--shadow-soft)" />
        </div>
    </x-ui.section>
</x-layouts.app>

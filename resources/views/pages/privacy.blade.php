<x-layouts.app :title="$content['privacy_hero_eyebrow'] ?? __('Privacy & Cookies')">
    <x-ui.page-hero :eyebrow="$content['privacy_hero_eyebrow'] ?? __('Privacy & Cookies')" :subtext="$content['privacy_hero_subtext'] ?? __('A plain-language account of what this site stores in your browser and why — nothing more than what\'s listed here.')">
        {{ $content['privacy_hero_heading'] ?? __('What we store, and why.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="max-w-2xl space-y-10">
            <div>
                <x-ui.section-header :eyebrow="$content['privacy_cookies_eyebrow'] ?? __('Cookies we set')">{{ $content['privacy_cookies_heading'] ?? __('Essential only.') }}</x-ui.section-header>
                @php
                    $cookies = collect([1, 2, 3])->map(fn ($i) => [
                        'name' => $content['privacy_cookie_'.$i.'_name'] ?? '',
                        'body' => $content['privacy_cookie_'.$i.'_body'] ?? '',
                    ]);
                @endphp
                <ul class="reveal-stagger mt-8 space-y-5">
                    @foreach ($cookies as $cookie)
                        <li class="card-hard p-5">
                            <p class="font-black text-fg">{{ $cookie['name'] }}</p>
                            <p class="mt-1 text-sm leading-relaxed text-muted">{{ $cookie['body'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <x-ui.section-header :eyebrow="$content['privacy_storage_eyebrow'] ?? __('Stored in your browser')">{{ $content['privacy_storage_heading'] ?? __('Not sent to us.') }}</x-ui.section-header>
                <p class="mt-6 text-balance text-lg leading-relaxed text-muted">
                    {{ $content['privacy_storage_body'] ?? __('Your light/dark mode preference is saved with localStorage rather than a cookie — it stays on your device and is never transmitted to our server.') }}
                </p>
            </div>

            <div>
                <x-ui.section-header :eyebrow="$content['privacy_notrack_eyebrow'] ?? __('What we don\'t use')">{{ $content['privacy_notrack_heading'] ?? __('No tracking.') }}</x-ui.section-header>
                <p class="mt-6 text-balance text-lg leading-relaxed text-muted">
                    {{ $content['privacy_notrack_body'] ?? __('No advertising cookies, no analytics trackers, and nothing that follows you to other websites. If that ever changes, this page — and the notice you saw — changes with it.') }}
                </p>
            </div>
        </div>
    </x-ui.section>
</x-layouts.app>

<x-layouts.app :title="__('Privacy & Cookies')">
    <x-ui.page-hero :eyebrow="__('Privacy & Cookies')" :subtext="__('A plain-language account of what this site stores in your browser and why — nothing more than what\'s listed here.')">
        {{ __('What we store, and why.') }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="max-w-2xl space-y-10">
            <div>
                <x-ui.section-header :eyebrow="__('Cookies we set')">{{ __('Essential only.') }}</x-ui.section-header>
                <ul class="reveal-stagger mt-8 space-y-5">
                    <li class="card-hard p-5">
                        <p class="font-black text-fg">{{ __('Session cookie') }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-muted">{{ __('Keeps you signed in to the admin panel and protects every form on this site (contact, newsletter, chat) against cross-site request forgery. The site cannot function without it.') }}</p>
                    </li>
                    <li class="card-hard p-5">
                        <p class="font-black text-fg">{{ __('locale') }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-muted">{{ __('Remembers the language you chose from the switcher, so you don\'t have to pick it again on your next visit. Expires after a year.') }}</p>
                    </li>
                    <li class="card-hard p-5">
                        <p class="font-black text-fg">cookie_consent</p>
                        <p class="mt-1 text-sm leading-relaxed text-muted">{{ __('Remembers that you\'ve dismissed the cookie notice, so it doesn\'t show again. Expires after a year.') }}</p>
                    </li>
                </ul>
            </div>

            <div>
                <x-ui.section-header :eyebrow="__('Stored in your browser')">{{ __('Not sent to us.') }}</x-ui.section-header>
                <p class="mt-6 text-balance text-lg leading-relaxed text-muted">
                    {{ __('Your light/dark mode preference is saved with localStorage rather than a cookie — it stays on your device and is never transmitted to our server.') }}
                </p>
            </div>

            <div>
                <x-ui.section-header :eyebrow="__('What we don\'t use')">{{ __('No tracking.') }}</x-ui.section-header>
                <p class="mt-6 text-balance text-lg leading-relaxed text-muted">
                    {{ __('No advertising cookies, no analytics trackers, and nothing that follows you to other websites. If that ever changes, this page — and the notice you saw — changes with it.') }}
                </p>
            </div>
        </div>
    </x-ui.section>
</x-layouts.app>

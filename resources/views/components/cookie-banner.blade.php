{{--
    Server-driven, not a JS toggle: whether this renders at all depends on
    the real `cookie_consent` cookie CookieConsentController sets (see its
    own comment for why), so the banner never flashes on load and works
    even without JavaScript — the same reasoning the locale cookie already
    follows. Single acknowledgement, not an accept/decline pair — the site
    doesn't set any non-essential cookies to decline (see the Privacy page
    for exactly what's used), so a "decline" choice that changed nothing
    would be dishonest. If that changes, this needs a real opt-out to go
    with it.
--}}
@unless (request()->cookie('cookie_consent'))
    <div
        role="region"
        aria-label="{{ __('Cookie notice') }}"
        class="fixed inset-x-0 bottom-0 z-[60] border-t border-hairline bg-cream"
    >
        <div class="mx-auto flex w-full max-w-[120rem] flex-col items-center gap-4 px-6 py-5 sm:flex-row sm:justify-between sm:px-8">
            <p class="text-sm text-fg">
                {{ __('We use a small number of cookies for essential site functionality — nothing here tracks you across other websites.') }}
                <a href="{{ route('privacy') }}" class="font-bold underline hover:text-primary-soft">{{ __('Learn more') }}</a>
            </p>
            <form method="POST" action="{{ route('cookie-consent.store') }}" class="shrink-0">
                @csrf
                <x-ui.button type="submit" size="sm">{{ __('Got it') }}</x-ui.button>
            </form>
        </div>
    </div>
@endunless

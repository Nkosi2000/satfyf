{{--
    Single acknowledgement, not an accept/decline pair — the site doesn't
    set any non-essential cookies to decline (no analytics/tracking
    scripts), so offering a "decline" choice that does nothing would be
    dishonest. If that changes, this needs a real opt-out to go with it.
--}}
<div
    data-cookie-banner
    hidden
    role="region"
    aria-label="{{ __('Cookie notice') }}"
    class="fixed inset-x-0 bottom-0 z-[60] border-t-[3px] border-fg bg-surface"
>
    <div class="mx-auto flex w-full max-w-[120rem] flex-col items-center gap-4 px-6 py-5 sm:flex-row sm:justify-between sm:px-8">
        <p class="text-sm text-fg">
            {{ __('We use a small number of cookies for essential site functionality — nothing here tracks you across other websites.') }}
        </p>
        <x-ui.button type="button" data-cookie-accept size="sm" class="shrink-0">
            {{ __('Got it') }}
        </x-ui.button>
    </div>
</div>

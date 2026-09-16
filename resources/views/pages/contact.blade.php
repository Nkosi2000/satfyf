<x-layouts.app :title="__('Contact Us')">
    <x-ui.page-hero eyebrow="{{ __('Contact Us') }}" subtext="{{ __('Questions about starting a chapter, media enquiries, partnership ideas, or just something on your mind — reach us directly, or send a message below.') }}">
        {{ __("Let's talk.") }}
    </x-ui.page-hero>

    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-16 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="space-y-6">
                <p class="text-balance text-lg leading-relaxed text-muted">{{ __("We're a small, youth-led team, so a real person reads every message — expect a reply within a few working days.") }}</p>
                @if (! empty($contact['contact_address']))
                    <div>
                        <p class="text-xs tracking-[0.14em] text-faint uppercase">{{ __('Address') }}</p>
                        <p class="mt-2 text-sm text-fg">{{ $contact['contact_address'] }}</p>
                    </div>
                @endif
                @if (! empty($contact['contact_phone_office']))
                    <div>
                        <p class="text-xs tracking-[0.14em] text-faint uppercase">{{ __('Phone') }}</p>
                        <p class="mt-2 text-sm text-fg">
                            <a href="tel:{{ $contact['contact_phone_office'] }}" class="hover:text-primary-soft">{{ $contact['contact_phone_office'] }}</a> ({{ __('office') }})
                            @if (! empty($contact['contact_phone_mobile']))
                                <br /><a href="tel:{{ $contact['contact_phone_mobile'] }}" class="hover:text-primary-soft">{{ $contact['contact_phone_mobile'] }}</a> ({{ __('mobile') }})
                            @endif
                        </p>
                    </div>
                @endif
                @if (! empty($contact['contact_email']))
                    <div>
                        <p class="text-xs tracking-[0.14em] text-faint uppercase">{{ __('Email') }}</p>
                        <p class="mt-2 text-sm text-fg">
                            <a href="mailto:{{ $contact['contact_email'] }}" class="hover:text-primary-soft">{{ $contact['contact_email'] }}</a>
                        </p>
                    </div>
                @endif
            </div>

            <x-contact-form />
        </div>
    </x-ui.section>
</x-layouts.app>

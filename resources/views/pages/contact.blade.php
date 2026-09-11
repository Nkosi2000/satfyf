<x-layouts.app :title="__('Contact Us')">
    <section class="pt-24 pb-20 sm:pt-32">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>{{ __('Contact Us') }}</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-fg sm:text-6xl">{{ __("Let's talk.") }}</h1>
        </x-ui.section>
    </section>

    <x-ui.section class="hairline-t" width="wide">
        <div class="grid gap-16 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="space-y-6">
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

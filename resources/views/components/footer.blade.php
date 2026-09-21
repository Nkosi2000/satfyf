@php
    $explore = [
        ['label' => __('Who We Are'), 'route' => 'who-we-are'],
        ['label' => __('Why We Exist'), 'route' => 'why-we-exist'],
        ['label' => __('What We Do'), 'route' => 'what-we-do'],
        ['label' => __('Get Involved'), 'route' => 'get-involved'],
    ];

    $resourcesNav = [
        ['label' => __('Articles'), 'route' => 'articles.index'],
        ['label' => __('Events'), 'route' => 'events.index'],
        ['label' => __('Resources'), 'route' => 'resources.index'],
        ['label' => __('Gallery'), 'route' => 'gallery'],
        ['label' => __('Partners'), 'route' => 'partners'],
    ];

    $socials = [
        ['label' => 'Facebook', 'url' => $settings['social_facebook'] ?? null, 'icon' => 'facebook'],
        ['label' => 'Instagram', 'url' => $settings['social_instagram'] ?? null, 'icon' => 'instagram'],
        ['label' => 'Twitter', 'url' => $settings['social_twitter'] ?? null, 'icon' => 'twitter'],
        ['label' => 'YouTube', 'url' => $settings['social_youtube'] ?? null, 'icon' => 'youtube'],
    ];
@endphp

<footer class="border-t border-hairline bg-cream-raised">
    <x-ui.section width="wide" class="!py-16">
        <div class="grid gap-12 lg:grid-cols-[1.3fr_1fr_1fr_1.2fr]">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <img src="{{ asset('images/48 x 48.png') }}" alt="SATFYF" class="brand-mark h-14 w-14 rounded-full object-cover" style="box-shadow: var(--shadow-soft-sm)" />
                </a>
                <p class="mt-4 max-w-xs text-sm text-muted">
                    {{ $settings['footer_tagline'] ?? __('A smoke free generation in our lifetime.') }}
                </p>
                <x-newsletter-form class="mt-6" />
            </div>

            <div>
                <h3 class="text-sm font-black tracking-wide text-fg uppercase">{{ __('Explore') }}</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($explore as $link)
                        <li><a href="{{ route($link['route']) }}" class="text-sm text-muted hover:text-fg">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-black tracking-wide text-fg uppercase">{{ __('Resources') }}</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($resourcesNav as $link)
                        <li><a href="{{ route($link['route']) }}" class="text-sm text-muted hover:text-fg">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-black tracking-wide text-fg uppercase">{{ __('Contact') }}</h3>
                <ul class="mt-4 space-y-3 text-sm text-muted">
                    @if (! empty($settings['contact_address']))
                        <li>{{ $settings['contact_address'] }}</li>
                    @endif
                    @if (! empty($settings['contact_phone_office']))
                        <li><a href="tel:{{ $settings['contact_phone_office'] }}" class="hover:text-fg">{{ $settings['contact_phone_office'] }}</a></li>
                    @endif
                    @if (! empty($settings['contact_email']))
                        <li><a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-fg">{{ $settings['contact_email'] }}</a></li>
                    @endif
                </ul>

                <div class="mt-5 flex items-center gap-3">
                    @foreach ($socials as $social)
                        @if ($social['url'])
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ $social['label'] }}"
                                class="press flex h-11 w-11 items-center justify-center rounded-full bg-surface text-fg"
                                style="box-shadow: var(--shadow-soft-sm)"
                            >
                                <x-icon.social :name="$social['icon']" class="h-4 w-4" />
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="hairline-t mt-12 flex flex-col gap-3 pt-8 text-xs text-faint sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ __('South African Tobacco-Free Youth Forum. All rights reserved.') }}</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-fg">{{ __('Privacy & Cookies') }}</a>
                <p>{{ __('We speak and spread the truth about smoking.') }}</p>
            </div>
        </div>
    </x-ui.section>
</footer>

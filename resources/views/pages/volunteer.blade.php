<x-layouts.app :title="$content['volunteer_hero_eyebrow'] ?? __('Volunteer')">
    <x-ui.page-hero :eyebrow="$content['volunteer_hero_eyebrow'] ?? __('Volunteer')" :subtext="$content['volunteer_hero_subtext'] ?? null">
        {{ $content['volunteer_hero_heading'] ?? __('Give your time. Change the culture.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @if ($roles->isNotEmpty())
        <x-ui.section class="section-divider" width="wide" triangles="bottom-right">
            <x-ui.section-header wide :eyebrow="$content['volunteer_roles_eyebrow'] ?? __('Ways to help')">{{ $content['volunteer_roles_heading'] ?? __('Find your role.') }}</x-ui.section-header>
            <div class="reveal-stagger mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($roles as $role)
                    <x-ui.info-card
                        :title="$role['title']"
                        :href="route('volunteer', ['interest' => $role['title']]).'#contact-form'"
                        :link-label="__('I\'m interested')"
                    >{{ $role['body'] }}</x-ui.info-card>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section id="contact-form" class="section-divider" width="wide" triangles="bottom-left">
        <x-ui.section-header wide :eyebrow="$content['volunteer_form_eyebrow'] ?? __('Sign up')">{{ $content['volunteer_form_heading'] ?? __("Tell us how you'd like to help.") }}</x-ui.section-header>
        <x-contact-form :subject="request()->query('interest', __('Volunteering'))" class="mt-8" />
    </x-ui.section>
</x-layouts.app>

<x-layouts.app :title="$getInvolved['get_involved_hero_eyebrow'] ?? __('Get Involved')">
    <x-ui.page-hero :eyebrow="$getInvolved['get_involved_hero_eyebrow'] ?? __('Get Involved')" :subtext="$getInvolved['get_involved_hero_subtext'] ?? __('There\'s no membership fee, and no single way in. Pick what fits.')">
        {{ $getInvolved['get_involved_hero_heading'] ?? __('Help achieve a culture where young people reject tobacco.') }}

        <x-slot:image>
            <x-ui.brand-hero-image />
        </x-slot:image>
    </x-ui.page-hero>

    @if (! empty($getInvolved['get_involved_statement']))
        <x-ui.section class="hairline-t" width="wide">
            <p class="max-w-3xl text-balance text-lg leading-relaxed text-muted sm:text-xl">
                {{ $getInvolved['get_involved_statement'] }}
            </p>
            @if (! empty($getInvolved['get_involved_join_form_url']))
                <x-ui.button
                    href="{{ $getInvolved['get_involved_join_form_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    size="lg"
                    class="mt-6"
                >
                    {{ __('Join the Forum') }}
                </x-ui.button>
            @endif
        </x-ui.section>
    @endif

    <x-ui.section class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="$getInvolved['get_involved_ways_eyebrow'] ?? __('Ways In')">{{ $getInvolved['get_involved_ways_heading'] ?? __('Four ways to get involved.') }}</x-ui.section-header>

        <div class="reveal-stagger mt-10 grid gap-6 sm:grid-cols-2">
            @php
                $ways = collect([1, 2, 3, 4])
                    ->map(fn ($i) => [
                        'title' => $getInvolved['get_involved_way_'.$i.'_title'] ?? '',
                        'body' => $getInvolved['get_involved_way_'.$i.'_body'] ?? '',
                    ])
                    ->filter(fn ($way) => $way['title'] !== '');
            @endphp
            @foreach ($ways as $way)
                <x-ui.card class="flex flex-col">
                    <p class="text-2xl font-black text-fg">{{ $way['title'] }}</p>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $way['body'] }}</p>
                    <a href="{{ route('get-involved', ['interest' => $way['title']]).'#contact-form' }}" class="mt-4 text-sm font-bold text-primary-soft hover:underline">
                        {{ __("I'm interested") }} &rarr;
                    </a>
                </x-ui.card>
            @endforeach
        </div>
    </x-ui.section>

    <x-ui.section id="contact-form" class="hairline-t" width="wide">
        <x-ui.section-header :eyebrow="$getInvolved['get_involved_reach_eyebrow'] ?? __('Reach Out')">{{ $getInvolved['get_involved_reach_heading'] ?? __("Tell us what you'd like to do.") }}</x-ui.section-header>
        <x-contact-form :subject="request()->query('interest', 'Getting involved')" class="mt-8" />
    </x-ui.section>

    @if ($faqs->isNotEmpty())
        <x-ui.section class="hairline-t" width="wide">
            <x-ui.section-header>{{ $getInvolved['get_involved_questions_heading'] ?? __('Questions.') }}</x-ui.section-header>
            <x-ui.accordion class="reveal-stagger mt-8">
                @foreach ($faqs as $faq)
                    <x-ui.accordion-item :question="$faq->question">{{ $faq->answer }}</x-ui.accordion-item>
                @endforeach
            </x-ui.accordion>
        </x-ui.section>
    @endif
</x-layouts.app>

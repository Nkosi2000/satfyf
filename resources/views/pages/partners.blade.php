<x-layouts.app title="Partners &amp; Collaborative">
    <section class="pt-20 pb-16 sm:pt-28">
        <x-ui.section width="narrow" class="!py-0">
            <x-ui.eyebrow>Partners &amp; Collaborative</x-ui.eyebrow>
            <h1 class="mt-5 text-balance font-serif text-5xl leading-[1.05] text-cream sm:text-6xl">We don't do this alone.</h1>
        </x-ui.section>
    </section>

    @foreach ($types as $type)
        @if ($partners->has($type->value))
            <x-ui.section class="hairline-t">
                <x-ui.section-header :eyebrow="$type->label()">
                    {{ $partners[$type->value]->count() }} organisations
                </x-ui.section-header>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners[$type->value] as $partner)
                        <x-ui.card class="flex items-center gap-4">
                            @if ($partner->logo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="h-10 w-10 rounded-lg object-cover" />
                            @endif
                            <div>
                                <p class="font-medium text-cream">{{ $partner->name }}</p>
                                @if ($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-muted hover:text-ember-soft">Visit site &rarr;</a>
                                @endif
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
            </x-ui.section>
        @endif
    @endforeach
</x-layouts.app>

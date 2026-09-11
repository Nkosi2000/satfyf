@props(['align' => 'left'])

<div {{ $attributes }}>
    @if (session('newsletter_success'))
        <p class="mb-3 text-sm text-ember-soft">{{ session('newsletter_success') }}</p>
    @endif

    <form
        method="POST"
        action="{{ route('newsletter.store') }}"
        class="flex w-full max-w-sm flex-col gap-3 sm:flex-row {{ $align === 'center' ? 'mx-auto' : '' }}"
    >
        @csrf
        <label for="newsletter-email" class="sr-only">Email address</label>
        <input
            id="newsletter-email"
            type="email"
            name="email"
            required
            placeholder="you@example.com"
            value="{{ old('email') }}"
            class="w-full rounded-full border border-hairline-strong bg-surface px-4 py-2.5 text-sm text-cream placeholder:text-faint focus:border-ember-soft"
        />
        <x-ui.button type="submit" size="sm" class="shrink-0">Subscribe</x-ui.button>
    </form>

    @error('email')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>

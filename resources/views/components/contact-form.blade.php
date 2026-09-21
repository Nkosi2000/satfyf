@props(['subject' => null])

<div {{ $attributes }}>
    @if (session('contact_success'))
        <p class="mb-4 rounded-lg bg-primary px-4 py-3 text-sm font-bold text-on-accent">{{ session('contact_success') }}</p>
    @endif

    <form method="POST" action="{{ route('contact.store') }}" class="grid gap-5 sm:grid-cols-2">
        @csrf
        <div class="flex flex-col gap-1.5">
            <label for="contact-name" class="text-sm font-bold text-muted">{{ __('Name') }}</label>
            <input id="contact-name" name="name" type="text" required value="{{ old('name') }}" class="rounded-lg border border-hairline-strong bg-surface px-3 py-2.5 text-sm font-bold text-fg focus:border-primary-soft" />
            @error('name') <p class="text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="contact-email" class="text-sm font-bold text-muted">{{ __('Email') }}</label>
            <input id="contact-email" name="email" type="email" required value="{{ old('email') }}" class="rounded-lg border border-hairline-strong bg-surface px-3 py-2.5 text-sm font-bold text-fg focus:border-primary-soft" />
            @error('email') <p class="text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="contact-phone" class="text-sm font-bold text-muted">{{ __('Phone (optional)') }}</label>
            <input id="contact-phone" name="phone" type="tel" value="{{ old('phone') }}" class="rounded-lg border border-hairline-strong bg-surface px-3 py-2.5 text-sm font-bold text-fg focus:border-primary-soft" />
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="contact-subject" class="text-sm font-bold text-muted">{{ __('Subject') }}</label>
            <input id="contact-subject" name="subject" type="text" value="{{ old('subject', $subject) }}" class="rounded-lg border border-hairline-strong bg-surface px-3 py-2.5 text-sm font-bold text-fg focus:border-primary-soft" />
        </div>

        <div class="flex flex-col gap-1.5 sm:col-span-2">
            <label for="contact-message" class="text-sm font-bold text-muted">{{ __('Message') }}</label>
            <textarea id="contact-message" name="message" rows="5" required class="rounded-lg border border-hairline-strong bg-surface px-3 py-2.5 text-sm font-bold text-fg focus:border-primary-soft">{{ old('message') }}</textarea>
            @error('message') <p class="text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <x-ui.button type="submit">{{ __('Send message') }}</x-ui.button>
        </div>
    </form>
</div>

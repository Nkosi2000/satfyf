@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'options' => [],
    'hint' => null,
])

@php
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $old = old($errorKey, $value);
    $inputClasses = 'w-full rounded-lg border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg transition-colors focus:border-primary-soft focus:outline-none';
@endphp

<div {{ $attributes->class(['flex flex-col gap-1.5']) }}>
    <label for="field-{{ $name }}" class="text-sm font-medium text-fg">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea
            id="field-{{ $name }}"
            name="{{ $name }}"
            rows="6"
            {{ $attributes->whereStartsWith('data-') }}
            class="{{ $inputClasses }}"
        >{{ $old }}</textarea>
    @elseif ($type === 'select')
        {{-- autocomplete="off" stops browsers (Firefox especially) restoring
             a previously chosen option on Back/reload, which would silently
             resubmit a stale value instead of the one saved in the database. --}}
        <select id="field-{{ $name }}" name="{{ $name }}" autocomplete="off" class="{{ $inputClasses }}">
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $old === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @elseif ($type === 'checkbox')
        <label class="flex items-center gap-2 text-sm text-fg">
            <input type="hidden" name="{{ $name }}" value="0" />
            <input
                id="field-{{ $name }}"
                type="checkbox"
                name="{{ $name }}"
                value="1"
                @checked(old($errorKey, $value) ? true : false)
                class="h-4 w-4 rounded border-hairline-strong accent-primary"
            />
            {{ $slot->isNotEmpty() ? $slot : 'Enabled' }}
        </label>
    @elseif ($type === 'file')
        <input
            id="field-{{ $name }}"
            type="file"
            name="{{ $name }}"
            data-image-input="{{ $name }}"
            accept="{{ $attributes->get('accept', 'image/*') }}"
            class="{{ $inputClasses }} file:mr-3 file:rounded-md file:border-0 file:bg-surface-2 file:px-3 file:py-1.5 file:text-sm file:text-fg"
        />
        @if ($value)
            <img data-image-preview="{{ $name }}" src="{{ storage_url($value) }}" class="mt-2 h-20 w-20 rounded-lg object-cover" alt="" />
        @else
            <img data-image-preview="{{ $name }}" hidden class="mt-2 h-20 w-20 rounded-lg object-cover" alt="" />
        @endif
    @elseif ($type === 'password')
        <div class="relative" data-password-field>
            <input
                id="field-{{ $name }}"
                type="password"
                name="{{ $name }}"
                class="{{ $inputClasses }} pr-11"
            />
            <button
                type="button"
                data-password-toggle
                aria-controls="field-{{ $name }}"
                aria-pressed="false"
                aria-label="Show password"
                class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg text-muted transition-colors hover:text-fg focus-visible:text-fg focus-visible:outline-none"
            >
                <svg data-password-icon="show" viewBox="0 0 20 20" fill="none" class="h-4.5 w-4.5" aria-hidden="true">
                    <path d="M1.75 10S4.75 4 10 4s8.25 6 8.25 6-3 6-8.25 6S1.75 10 1.75 10Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    <circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.5" />
                </svg>
                <svg data-password-icon="hide" hidden viewBox="0 0 20 20" fill="none" class="h-4.5 w-4.5" aria-hidden="true">
                    <path d="M8.2 4.2A7.6 7.6 0 0 1 10 4c5.25 0 8.25 6 8.25 6a14 14 0 0 1-2.1 2.9M5.4 5.6C3 7.1 1.75 10 1.75 10S4.75 16 10 16c1.5 0 2.8-.5 3.9-1.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8.2 8.3a2.5 2.5 0 0 0 3.5 3.5M2.5 2.5l15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
        </div>
    @else
        <input
            id="field-{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $old }}"
            class="{{ $inputClasses }}"
        />
    @endif

    @if ($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif

    @error($errorKey)
        <p class="text-xs text-danger-soft">{{ $message }}</p>
    @enderror
</div>

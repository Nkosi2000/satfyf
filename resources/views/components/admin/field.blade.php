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
        <select id="field-{{ $name }}" name="{{ $name }}" class="{{ $inputClasses }}">
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

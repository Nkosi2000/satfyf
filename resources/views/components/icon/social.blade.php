@props(['name'])

@switch($name)
    @case('facebook')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor']) }} aria-hidden="true">
            <path d="M13.5 21v-7.8h2.6l.4-3h-3v-1.9c0-.87.24-1.46 1.5-1.46h1.6V4.14C15.9 4.05 15.02 4 13.98 4c-2.16 0-3.64 1.32-3.64 3.74v2.46H7.7v3h2.64V21h3.16Z" />
        </svg>
        @break

    @case('instagram')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3.5" y="3.5" width="17" height="17" rx="5" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
            <circle cx="17" cy="7" r="1" fill="currentColor" />
        </svg>
        @break

    @case('twitter')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor']) }} aria-hidden="true">
            <path d="M18.9 4h2.9l-6.4 7.3L23 20h-5.9l-4.6-6-5.3 6H4.3l6.9-7.8L4 4h6.1l4.2 5.6L18.9 4Zm-1 14.4h1.6L8.2 5.5H6.5L17.9 18.4Z" />
        </svg>
        @break

    @case('youtube')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3" y="6" width="18" height="12" rx="3" stroke="currentColor" stroke-width="1.5" />
            <path d="M10.5 9.5v5l4.5-2.5-4.5-2.5Z" fill="currentColor" />
        </svg>
        @break
@endswitch

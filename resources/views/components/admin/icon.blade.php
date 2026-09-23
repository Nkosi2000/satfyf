@props(['name'])

{{-- Same hand-authored, single-stroke SVG pattern as x-icon.social/
     x-icon.vision — a small curated set for the admin sidebar's icon rail,
     not a general-purpose icon library. --}}
@switch($name)
    @case('grid')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="4" y="4" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.5" />
            <rect x="13" y="4" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.5" />
            <rect x="4" y="13" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.5" />
            <rect x="13" y="13" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.5" />
        </svg>
        @break

    @case('home')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M4 11.5 12 4l8 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6 10v9h12v-9" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M10 19v-5h4v5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @case('users')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="9" cy="8.5" r="3" stroke="currentColor" stroke-width="1.5" />
            <path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M15.5 5.8c1.4.4 2.5 1.7 2.5 3.2 0 1.5-1 2.7-2.3 3.2M17.5 14.3c2 .4 3.5 2 3.5 4.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('info')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
            <path d="M12 11v5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="12" cy="8" r="1" fill="currentColor" />
        </svg>
        @break

    @case('layers')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M12 4 4 8.5 12 13l8-4.5L12 4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M4 13 12 17.5 20 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M4 17.5 12 22l8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('heart')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M12 20s-7-4.4-9.3-9C1.3 8 2.6 5 5.6 4.4 7.8 4 9.8 5 12 7.5 14.2 5 16.2 4 18.4 4.4c3 .6 4.3 3.6 2.9 6.6C19 15.6 12 20 12 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @case('mail')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3.5" y="5.5" width="17" height="13" rx="2" stroke="currentColor" stroke-width="1.5" />
            <path d="m4.5 7 7.5 6 7.5-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('send')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M20 4 3 11l6.5 2.5L12 20l3-6 5-10Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M20 4 9.5 13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('shield')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M12 3.5 5 6v5.2c0 4.4 3 7.9 7 9.3 4-1.4 7-4.9 7-9.3V6l-7-2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('document')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M6.5 3.5h8l4 4V20a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M14 3.5V8h4" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M8.5 13h7M8.5 16.5h7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('calendar')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3.5" y="5" width="17" height="15" rx="2" stroke="currentColor" stroke-width="1.5" />
            <path d="M3.5 9.5h17M8 3.5v3M16 3.5v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('quote')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M7 7.5c-1.7.7-2.8 2.2-2.8 4.2 0 1.8 1.2 3 2.7 3s2.6-1.1 2.6-2.7c0-1.4-.9-2.4-2.1-2.6.1-1 .9-1.9 2.1-2.4L7 7.5Z" fill="currentColor" />
            <path d="M15.8 7.5c-1.7.7-2.8 2.2-2.8 4.2 0 1.8 1.2 3 2.7 3s2.6-1.1 2.6-2.7c0-1.4-.9-2.4-2.1-2.6.1-1 .9-1.9 2.1-2.4l-2.5.5Z" fill="currentColor" />
        </svg>
        @break

    @case('download')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M12 4v11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="m8 11.5 4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M4.5 17.5V19a1.5 1.5 0 0 0 1.5 1.5h12a1.5 1.5 0 0 0 1.5-1.5v-1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('image')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3.5" y="4.5" width="17" height="15" rx="2" stroke="currentColor" stroke-width="1.5" />
            <circle cx="8.5" cy="9.5" r="1.5" stroke="currentColor" stroke-width="1.5" />
            <path d="m5 17 4.5-4.5a1.5 1.5 0 0 1 2.1 0L15 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="m13.5 15 1.5-1.5a1.5 1.5 0 0 1 2.1 0L20 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('link')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M9.5 14.5 14.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M11 7l1.3-1.3a3.5 3.5 0 0 1 5 5L16 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M13 17l-1.3 1.3a3.5 3.5 0 0 1-5-5L8 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('question')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
            <path d="M9.5 9.3a2.5 2.5 0 1 1 3.7 2.2c-.8.5-1.2 1-1.2 1.9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="12" cy="16.3" r="1" fill="currentColor" />
        </svg>
        @break

    @case('target')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="12" r="1" fill="currentColor" />
        </svg>
        @break

    @case('share')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="18" cy="6" r="2.3" stroke="currentColor" stroke-width="1.5" />
            <circle cx="6" cy="12" r="2.3" stroke="currentColor" stroke-width="1.5" />
            <circle cx="18" cy="18" r="2.3" stroke="currentColor" stroke-width="1.5" />
            <path d="m8 10.8 8-3.6M8 13.2l8 3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('layout-bottom')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <rect x="3.5" y="3.5" width="17" height="17" rx="2" stroke="currentColor" stroke-width="1.5" />
            <path d="M3.5 15h17" stroke="currentColor" stroke-width="1.5" />
        </svg>
        @break

    @case('inbox')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <path d="M4 12.5h4.2l1.3 2.5h5l1.3-2.5H20" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M4.5 12.5 6 5.5A1.5 1.5 0 0 1 7.5 4.3h9a1.5 1.5 0 0 1 1.5 1.2l1.5 7" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="4" y="12.5" width="16" height="6.7" rx="1.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @case('user-circle')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="10" r="2.6" stroke="currentColor" stroke-width="1.5" />
            <path d="M6.5 18c.8-2.2 2.8-3.5 5.5-3.5s4.7 1.3 5.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" />
        </svg>
@endswitch

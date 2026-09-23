@props(['name'])

@switch($name)
    @case('shield')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'shield']) }} aria-hidden="true">
            <path d="M12 3.5 5 6v5.2c0 4.4 3 7.9 7 9.3 4-1.4 7-4.9 7-9.3V6l-7-2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('book')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'book']) }} aria-hidden="true">
            <path d="M4 5.5c2.2-1 4.8-1 7 0v13c-2.2-1-4.8-1-7 0v-13Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M20 5.5c-2.2-1-4.8-1-7 0v13c2.2-1 4.8-1 7 0v-13Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @case('users')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'users']) }} aria-hidden="true">
            <circle cx="9" cy="8.5" r="3" stroke="currentColor" stroke-width="1.5" />
            <path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M15.5 5.8c1.4.4 2.5 1.7 2.5 3.2 0 1.5-1 2.7-2.3 3.2M17.5 14.3c2 .4 3.5 2 3.5 4.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('heart')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'heart']) }} aria-hidden="true">
            <path d="M12 20s-7-4.4-9.3-9C1.3 8 2.6 5 5.6 4.4 7.8 4 9.8 5 12 7.5 14.2 5 16.2 4 18.4 4.4c3 .6 4.3 3.6 2.9 6.6C19 15.6 12 20 12 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @case('megaphone')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'megaphone']) }} aria-hidden="true">
            <path d="M3 10v4a1.5 1.5 0 0 0 1.5 1.5H6l4.5 4V4.5L6 8.5H4.5A1.5 1.5 0 0 0 3 10Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M14 9c1.3 1 1.3 5 0 6M17 6.5c2.6 1.7 2.6 9.3 0 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('leaf')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'leaf']) }} aria-hidden="true">
            <path d="M19 5c-8 0-14 4-14 12 8 0 12-3.5 14-9 .6-1.6.8-2.8 0-3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M5 19c2.5-4 6-6.5 11-9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('flag')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'flag']) }} aria-hidden="true">
            <path d="M6 20V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M6 5c3-1.3 5-1.3 8 0 2.3 1 3.3 1 4-.3v8c-.7 1.3-1.7 1.3-4 .3-3-1.3-5-1.3-8 0V5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'data-icon' => 'target']) }} aria-hidden="true">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
            <circle cx="12" cy="12" r="1" fill="currentColor" />
        </svg>
@endswitch

@props(['items'])

{{-- Label/value rows (contact details, banking details). Rows with an
     empty value are dropped, so admin-optional fields simply disappear. --}}
@php
    $rows = collect($items)->filter(fn (array $item): bool => filled($item['value'] ?? null));
@endphp

@if ($rows->isNotEmpty())
    <dl {{ $attributes->class(['card-soft divide-y divide-hairline']) }}>
        @foreach ($rows as $row)
            <div class="flex flex-col gap-1 px-6 py-4 sm:flex-row sm:items-baseline sm:justify-between sm:gap-6">
                <dt class="text-sm font-bold tracking-wide text-muted uppercase">{{ $row['label'] }}</dt>
                <dd class="text-lg font-bold text-fg sm:text-right">
                    @if (! empty($row['href']))
                        <a href="{{ $row['href'] }}" class="hover:text-primary-soft">{{ $row['value'] }}</a>
                    @else
                        {{ $row['value'] }}
                    @endif
                </dd>
            </div>
        @endforeach
    </dl>
@endif

@props(['icon' => null, 'soft' => false])

{{-- `soft` is kept as an accepted (now unused) prop so every existing
     :soft="..." call site across the codebase still resolves cleanly —
     the tinted pill below is the only treatment site-wide now. --}}
<span {{ $attributes->merge(['class' => 'badge-soft']) }}>
    @if ($icon)
        <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
    @endif
    {{ $slot }}
</span>

{{--
    Same light/dark logo lockup used across every page-hero that has no
    genuinely contextual per-page image (an article cover, an event photo,
    a gallery shot) — see who-we-are.blade.php for where this pattern
    first shipped. Two <img> tags swapped by CSS rather than one image
    with a dark filter, since the light/dark source files are already
    colour-matched to each theme rather than derived from one another.
--}}
<img
    src="{{ asset('images/250px-by-100px-SATFYF-LOGO.jpg') }}"
    alt="SATFYF"
    class="w-full rounded-2xl [.dark_&]:hidden"
    style="box-shadow: var(--shadow-soft)"
/>
<img
    src="{{ asset('images/250px-by-100px-SATFYF-LOGO-dark-mode.jpg') }}"
    alt="SATFYF"
    class="hidden w-full rounded-2xl [.dark_&]:block"
    style="box-shadow: var(--shadow-soft)"
/>

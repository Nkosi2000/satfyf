export function initTheme() {
    const toggleButtons = document.querySelectorAll('[data-theme-toggle]');
    if (!toggleButtons.length) return;

    const darkIcons = document.querySelectorAll('[data-theme-icon="dark"]');
    const lightIcons = document.querySelectorAll('[data-theme-icon="light"]');

    // Shows the icon for the mode a click would switch *to* — a moon while
    // light is active (inviting a switch to dark), a sun while dark is
    // active — matching the Flowbite convention this is modelled on.
    //
    // Uses toggleAttribute rather than the `.hidden` IDL property: SVG
    // elements don't reliably reflect `.hidden` the way HTML elements do,
    // so setting `svg.hidden = false` can silently no-op (leaving the real
    // `hidden` attribute — and Tailwind's `[hidden]{display:none!important}`
    // preflight rule — untouched) while the property read-back still lies
    // and reports `false`.
    const syncIcons = () => {
        const isDark = document.documentElement.classList.contains('dark');
        darkIcons.forEach((icon) => icon.toggleAttribute('hidden', isDark));
        lightIcons.forEach((icon) => icon.toggleAttribute('hidden', !isDark));
    };

    syncIcons();

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
            syncIcons();
        });
    });
}

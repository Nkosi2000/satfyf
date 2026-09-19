// Mirrors the language-switcher module's dropdown pattern (same
// open/close/click-outside/Escape mechanics), just for a centred modal
// instead of an anchored menu.
export function initSearchModal() {
    const instances = Array.from(document.querySelectorAll('[data-search]'))
        .map((wrapper) => ({
            wrapper,
            toggle: wrapper.querySelector('[data-search-toggle]'),
            modal: wrapper.querySelector('[data-search-modal]'),
            input: wrapper.querySelector('[data-search-input]'),
        }))
        .filter(({ toggle, modal }) => toggle && modal);

    if (!instances.length) return;

    const closeAll = () => {
        instances.forEach(({ toggle, modal }) => {
            modal.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
        });
    };

    const open = (instance) => {
        closeAll();
        instance.modal.hidden = false;
        instance.toggle.setAttribute('aria-expanded', 'true');
        instance.input?.focus();
    };

    instances.forEach((instance) => {
        instance.toggle.addEventListener('click', () => {
            const wasOpen = !instance.modal.hidden;
            if (wasOpen) {
                closeAll();
            } else {
                open(instance);
            }
        });

        // The modal element itself is the full-screen backdrop, so a click
        // that lands directly on it (not on the panel inside) means the
        // visitor clicked outside the search panel.
        instance.modal.addEventListener('click', (event) => {
            if (event.target === instance.modal) closeAll();
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;

        const openInstance = instances.find(({ modal }) => !modal.hidden);
        if (openInstance) {
            closeAll();
            openInstance.toggle.focus();
        }
    });
}

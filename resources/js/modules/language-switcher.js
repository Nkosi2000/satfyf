export function initLanguageSwitcher() {
    const instances = Array.from(document.querySelectorAll('[data-lang-switcher]'))
        .map((switcher) => ({
            switcher,
            toggle: switcher.querySelector('[data-lang-toggle]'),
            menu: switcher.querySelector('[data-lang-menu]'),
        }))
        .filter(({ toggle, menu }) => toggle && menu);

    if (!instances.length) return;

    const closeAll = () => {
        instances.forEach(({ toggle, menu }) => {
            menu.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
        });
    };

    instances.forEach(({ switcher, toggle, menu }) => {
        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            const wasOpen = !menu.hidden;
            closeAll();
            menu.hidden = wasOpen;
            toggle.setAttribute('aria-expanded', String(!wasOpen));
        });
    });

    document.addEventListener('click', (event) => {
        const withinAnyInstance = instances.some(({ switcher }) => switcher.contains(event.target));
        if (!withinAnyInstance) closeAll();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;

        const open = instances.find(({ menu }) => !menu.hidden);
        if (open) {
            closeAll();
            open.toggle.focus();
        }
    });
}

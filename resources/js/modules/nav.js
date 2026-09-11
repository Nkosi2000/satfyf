export function initNav() {
    const header = document.querySelector('[data-site-header]');
    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

    if (header) {
        const onScroll = () => {
            header.classList.toggle('is-scrolled', window.scrollY > 8);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const isOpen = menu.dataset.open === 'true';
            menu.dataset.open = String(!isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                menu.dataset.open = 'false';
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }
}

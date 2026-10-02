const SECONDARY_NAV_KEY = 'secondary-nav';
const SECONDARY_NAV_CLOSED_CLASS = 'secondary-nav-closed';

// The open/closed class lives on <html> and is first applied by the inline
// script in the layout's <head>, before paint; this only keeps the toggle's
// aria state, the collapsed links' inert state and localStorage in sync.
function initSecondaryNav() {
    const toggle = document.querySelector('[data-secondary-nav-toggle]');
    const nav = document.querySelector('[data-secondary-nav]');

    if (!toggle || !nav) {
        return;
    }

    const root = document.documentElement;

    const sync = () => {
        const isOpen = !root.classList.contains(SECONDARY_NAV_CLOSED_CLASS);
        toggle.setAttribute('aria-expanded', String(isOpen));
        nav.inert = !isOpen;
    };

    sync();

    toggle.addEventListener('click', () => {
        const isClosed = root.classList.toggle(SECONDARY_NAV_CLOSED_CLASS);

        try {
            localStorage.setItem(SECONDARY_NAV_KEY, isClosed ? 'closed' : 'open');
        } catch {
            // Storage blocked (private mode etc.) — the toggle still works for this page view.
        }

        sync();
    });
}

export function initNav() {
    initSecondaryNav();

    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

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

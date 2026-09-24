// Toggles the admin sidebar between its full width and an icon-only rail.
// The initial state is applied synchronously by an inline script in
// admin/layout.blade.php's <head> (same technique as the dark-mode
// toggle) so there's no flash of the wrong width on load — this handler
// only needs to react to clicks from then on.
export function initAdminSidebar() {
    initNavGroups();

    const toggle = document.querySelector('[data-sidebar-toggle]');
    if (!toggle) return;

    toggle.setAttribute('aria-expanded', String(!document.documentElement.classList.contains('admin-sidebar-collapsed')));

    toggle.addEventListener('click', () => {
        const collapsed = document.documentElement.classList.toggle('admin-sidebar-collapsed');
        toggle.setAttribute('aria-expanded', String(!collapsed));

        try {
            localStorage.setItem('admin-sidebar-collapsed', String(collapsed));
        } catch {
            // Private browsing / storage disabled — collapse still works
            // for this page load, it just won't persist.
        }
    });
}

// Opens/closes a nav section (Pages, Content, ...) when its heading is
// clicked. The section holding the current page is rendered open by
// admin/layout.blade.php; the rest start closed.
function initNavGroups() {
    document.querySelectorAll('[data-nav-group-toggle]').forEach((toggle) => {
        const panel = document.getElementById(toggle.getAttribute('aria-controls'));
        if (!panel) return;

        toggle.addEventListener('click', () => {
            const open = toggle.getAttribute('aria-expanded') !== 'true';
            toggle.setAttribute('aria-expanded', String(open));
            panel.dataset.open = String(open);
        });
    });
}

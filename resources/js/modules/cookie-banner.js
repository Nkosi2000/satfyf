const STORAGE_KEY = 'cookie-consent';

export function initCookieBanner() {
    const banner = document.querySelector('[data-cookie-banner]');
    if (!banner) return;

    if (localStorage.getItem(STORAGE_KEY) === 'accepted') return;

    banner.hidden = false;

    banner.querySelector('[data-cookie-accept]')?.addEventListener('click', () => {
        localStorage.setItem(STORAGE_KEY, 'accepted');
        banner.hidden = true;
    });
}

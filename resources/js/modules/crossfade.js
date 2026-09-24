// Auto-rotating image crossfade (Who We Are → Goals & Objectives). Slides
// are stacked and faded via opacity, so the frame never changes size. Only
// runs while the slideshow is on screen and the tab is visible; starts
// paused for prefers-reduced-motion, and the pause button satisfies WCAG
// 2.2.2 for content that moves on its own.
const INTERVAL_MS = 5000;

export function initCrossfade() {
    document.querySelectorAll('[data-crossfade]').forEach((root) => {
        const slides = [...root.querySelectorAll('[data-crossfade-slide]')];
        if (slides.length < 2) return;

        const toggle = root.querySelector('[data-crossfade-toggle]');
        const toggleLabel = toggle?.querySelector('.sr-only');
        const pauseLabel = toggleLabel?.textContent ?? '';

        let index = 0;
        let paused = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let onScreen = false;
        let timer = null;

        const show = (next) => {
            slides[index].classList.replace('opacity-100', 'opacity-0');
            slides[index].setAttribute('aria-hidden', 'true');
            slides[next].classList.replace('opacity-0', 'opacity-100');
            slides[next].removeAttribute('aria-hidden');
            slides[next].loading = 'eager';
            index = next;
        };

        const schedule = () => {
            clearInterval(timer);
            timer = null;

            if (!paused && onScreen && !document.hidden) {
                timer = setInterval(() => show((index + 1) % slides.length), INTERVAL_MS);
            }
        };

        const syncToggle = () => {
            toggle?.setAttribute('aria-pressed', String(paused));
            if (toggleLabel) toggleLabel.textContent = paused ? toggle.dataset.playLabel || 'Play slideshow' : pauseLabel;
        };

        toggle?.addEventListener('click', () => {
            paused = !paused;
            syncToggle();
            schedule();
        });

        new IntersectionObserver(([entry]) => {
            onScreen = entry.isIntersecting;
            schedule();
        }).observe(root);

        document.addEventListener('visibilitychange', schedule);

        syncToggle();
    });
}

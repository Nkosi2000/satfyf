// Shows the button once the visitor has scrolled past one viewport height,
// rAF-throttled to match the scroll-progress bar's approach.
export function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');
    if (!button) return;

    const threshold = 480;
    let ticking = false;

    const update = () => {
        button.hidden = window.scrollY < threshold;
        ticking = false;
    };

    const onScroll = () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    };

    update();
    window.addEventListener('scroll', onScroll, { passive: true });

    button.addEventListener('click', () => {
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
    });
}

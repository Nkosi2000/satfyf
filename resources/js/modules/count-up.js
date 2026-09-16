// Animates each [data-count-to] stat from 0 up to its target value once it
// scrolls into view, splitting off any non-digit prefix/suffix (e.g. "100%",
// "42+") so the animated portion is always the numeric core.
export function initCountUp() {
    const elements = document.querySelectorAll('[data-count-to]');
    if (!elements.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const duration = 1400;

    const animate = (el) => {
        const raw = el.dataset.countTo;
        const match = raw.match(/^(\D*)(\d+(?:\.\d+)?)(\D*)$/);

        if (!match) {
            el.textContent = raw;
            return;
        }

        const [, prefix, numberStr, suffix] = match;
        const target = parseFloat(numberStr);
        const decimals = (numberStr.split('.')[1] || '').length;
        const format = (n) => `${prefix}${decimals ? n.toFixed(decimals) : Math.round(n)}${suffix}`;

        if (prefersReducedMotion) {
            el.textContent = format(target);
            return;
        }

        const start = performance.now();

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = format(target * eased);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        };

        requestAnimationFrame(step);
    };

    if (!('IntersectionObserver' in window)) {
        elements.forEach(animate);
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -40px 0px', threshold: 0.4 },
    );

    elements.forEach((el) => observer.observe(el));
}

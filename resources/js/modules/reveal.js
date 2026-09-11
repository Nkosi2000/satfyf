export function initReveal() {
    const elements = document.querySelectorAll('.reveal, .reveal-stagger');
    if (!elements.length) return;

    if (!('IntersectionObserver' in window)) {
        elements.forEach((el) => el.setAttribute('data-visible', 'true'));
        return;
    }

    // Fires only as each element actually reaches the viewport while
    // scrolling — no global timer, so nothing below the fold reveals early.
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-visible', 'true');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -40px 0px', threshold: 0.15 },
    );

    elements.forEach((el) => observer.observe(el));
}

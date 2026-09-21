// Magnetic buttons — a [data-magnetic] element subtly pulls toward the
// cursor while hovered, and springs back on leave. Skipped entirely on
// touch/reduced-motion, since neither a finger nor a visitor who asked for
// less motion benefits from a cursor-chasing effect.
export function initMagnetic() {
    const elements = document.querySelectorAll('[data-magnetic]');
    if (!elements.length) return;

    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!canHover || prefersReducedMotion) return;

    elements.forEach(setupMagnetic);
}

function setupMagnetic(el) {
    // How far the element is allowed to travel toward the cursor, and how
    // much of the raw cursor offset actually gets applied — a fraction, not
    // 1:1, so it reads as "pulled toward" rather than "stuck to" the cursor.
    const maxOffset = parseFloat(el.dataset.magneticStrength) || 14;
    const pull = 0.35;

    // Owns the hover scale-up here too, not a CSS hover:scale-* class —
    // once this module starts writing el.style.transform, an inline style
    // always wins over a class's transform regardless of :hover state, so
    // a separate CSS scale class would go silently dead the moment this
    // runs. One transform string, one owner.
    const hoverScale = 1.06;

    let rafId = null;
    let targetX = 0;
    let targetY = 0;
    let targetScale = 1;
    let currentX = 0;
    let currentY = 0;
    let currentScale = 1;

    const apply = () => {
        currentX += (targetX - currentX) * 0.2;
        currentY += (targetY - currentY) * 0.2;
        currentScale += (targetScale - currentScale) * 0.2;
        el.style.transform = `translate(${currentX.toFixed(2)}px, ${currentY.toFixed(2)}px) scale(${currentScale.toFixed(3)})`;

        const settled = Math.abs(targetX - currentX) < 0.1
            && Math.abs(targetY - currentY) < 0.1
            && Math.abs(targetScale - currentScale) < 0.001;

        if (!settled) {
            rafId = requestAnimationFrame(apply);
        } else {
            rafId = null;
        }
    };

    const start = () => {
        if (rafId === null) rafId = requestAnimationFrame(apply);
    };

    el.addEventListener('mouseenter', () => {
        targetScale = hoverScale;
        start();
    });

    el.addEventListener('mousemove', (event) => {
        const rect = el.getBoundingClientRect();
        const offsetX = event.clientX - (rect.left + rect.width / 2);
        const offsetY = event.clientY - (rect.top + rect.height / 2);

        targetX = Math.max(-maxOffset, Math.min(maxOffset, offsetX * pull));
        targetY = Math.max(-maxOffset, Math.min(maxOffset, offsetY * pull));
        start();
    });

    el.addEventListener('mouseleave', () => {
        targetX = 0;
        targetY = 0;
        targetScale = 1;
        start();
    });
}

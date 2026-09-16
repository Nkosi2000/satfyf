// Marks <html> when the tab itself isn't visible (backgrounded, minimised,
// switched away from), so purely-CSS continuous animations — the ambient
// backdrop, the vision ring, the partners marquee — can pause via a plain
// CSS rule instead of running forever in a tab nobody's looking at. WebGL
// canvases already pause themselves the same way (see webgl-canvas.js).
export function initVisibility() {
    const sync = () => {
        document.documentElement.classList.toggle('tab-hidden', document.hidden);
    };

    sync();
    document.addEventListener('visibilitychange', sync);
}

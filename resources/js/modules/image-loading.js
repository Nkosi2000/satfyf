export function initImageLoading() {
    const markLoaded = (img) => img.setAttribute('data-loaded', 'true');

    document.querySelectorAll('img').forEach((img) => {
        // Already in the browser cache — no shimmer needed.
        if (img.complete && img.naturalWidth > 0) {
            markLoaded(img);
            return;
        }

        img.addEventListener('load', () => markLoaded(img), { once: true });
        // A broken image shouldn't shimmer forever — let it settle to the
        // browser's broken-image icon instead.
        img.addEventListener('error', () => markLoaded(img), { once: true });
    });
}

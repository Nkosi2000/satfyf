import { DotLottie } from '@lottiefiles/dotlottie-web';

// Renders each [data-lottie] canvas with its .lottie file. Reduced-motion
// visitors get the animation's first frame instead of playback, matching
// the rest of the site's prefers-reduced-motion handling.
export function initLottie() {
    const canvases = document.querySelectorAll('[data-lottie]');
    if (!canvases.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    canvases.forEach((canvas) => {
        new DotLottie({
            canvas,
            src: canvas.dataset.lottie,
            loop: !prefersReducedMotion,
            autoplay: !prefersReducedMotion,
            renderConfig: { autoResize: true },
        });
    });
}

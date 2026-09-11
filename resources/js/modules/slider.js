export function initSliders() {
    document.querySelectorAll('[data-slider]').forEach((slider) => {
        const track = slider.querySelector('[data-slider-track]');
        const prev = slider.querySelector('[data-slider-prev]');
        const next = slider.querySelector('[data-slider-next]');
        if (!track) return;

        const scrollByCard = (direction) => {
            const card = track.querySelector(':scope > *');
            const distance = card ? card.getBoundingClientRect().width + 16 : track.clientWidth * 0.8;
            track.scrollBy({ left: direction * distance, behavior: 'smooth' });
        };

        prev?.addEventListener('click', () => scrollByCard(-1));
        next?.addEventListener('click', () => scrollByCard(1));
    });
}

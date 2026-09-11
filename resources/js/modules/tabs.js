export function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach((container) => {
        const triggers = container.querySelectorAll('[data-tab-trigger]');

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const target = trigger.dataset.tabTrigger;

                triggers.forEach((t) => t.setAttribute('aria-selected', String(t === trigger)));

                container.querySelectorAll('[data-tab-panel]').forEach((panel) => {
                    panel.hidden = panel.dataset.tabPanel !== target;
                });
            });
        });
    });
}

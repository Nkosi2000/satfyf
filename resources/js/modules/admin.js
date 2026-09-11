export function initAdmin() {
    document.querySelectorAll('[data-image-input]').forEach((input) => {
        const preview = document.querySelector(`[data-image-preview="${input.dataset.imageInput}"]`);
        if (!preview) return;

        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = () => {
                preview.src = String(reader.result);
                preview.hidden = false;
            };
            reader.readAsDataURL(file);
        });
    });

    document.querySelectorAll('[data-markdown-field]').forEach((wrapper) => {
        const textarea = wrapper.querySelector('textarea');
        const preview = wrapper.querySelector('[data-markdown-preview]');
        const writeTab = wrapper.querySelector('[data-markdown-tab="write"]');
        const previewTab = wrapper.querySelector('[data-markdown-tab="preview"]');
        const endpoint = wrapper.dataset.markdownField;

        if (!textarea || !preview || !writeTab || !previewTab || !endpoint) return;

        const showWrite = () => {
            textarea.hidden = false;
            preview.hidden = true;
            writeTab.setAttribute('aria-selected', 'true');
            previewTab.setAttribute('aria-selected', 'false');
        };

        const showPreview = async () => {
            preview.innerHTML = '<p class="text-muted">Loading preview…</p>';
            textarea.hidden = true;
            preview.hidden = false;
            writeTab.setAttribute('aria-selected', 'false');
            previewTab.setAttribute('aria-selected', 'true');

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                },
                body: JSON.stringify({ body: textarea.value }),
            });

            preview.innerHTML = response.ok ? await response.text() : '<p class="text-danger-soft">Could not render preview.</p>';
        };

        writeTab.addEventListener('click', showWrite);
        previewTab.addEventListener('click', showPreview);
    });
}

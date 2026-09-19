import { playClick } from './sound';

const STORAGE_KEY = 'satfyfbot_conversation_id';

export function initChatbot() {
    const root = document.querySelector('[data-chatbot]');
    if (!root) return;

    const toggle = root.querySelector('[data-chatbot-toggle]');
    const panel = root.querySelector('[data-chatbot-panel]');
    const closeButton = root.querySelector('[data-chatbot-close]');
    const messages = root.querySelector('[data-chatbot-messages]');
    const typing = root.querySelector('[data-chatbot-typing]');
    const form = root.querySelector('[data-chatbot-form]');
    const input = root.querySelector('[data-chatbot-input]');
    const sendButton = root.querySelector('[data-chatbot-send]');
    const openIcon = root.querySelector('[data-chatbot-icon="open"]');
    const closeIcon = root.querySelector('[data-chatbot-icon="close"]');

    if (!toggle || !panel || !form || !input || !messages) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const errorMessage = root.dataset.errorMessage;
    const rateLimitMessage = root.dataset.rateLimitMessage;

    let conversationId = localStorage.getItem(STORAGE_KEY);
    let historyLoaded = false;

    const scrollToBottom = () => {
        messages.scrollTop = messages.scrollHeight;
    };

    const appendMessage = (role, content) => {
        const row = document.createElement('div');
        row.className = `flex items-start gap-2 ${role === 'user' ? 'justify-end' : ''}`;

        const bubble = document.createElement('div');
        bubble.className = role === 'user'
            ? 'max-w-[85%] rounded-2xl rounded-br-sm bg-primary-soft/15 px-3.5 py-2.5 text-sm text-fg'
            : 'max-w-[85%] rounded-2xl rounded-bl-sm bg-surface-2 px-3.5 py-2.5 text-sm text-fg';
        bubble.textContent = content;

        row.appendChild(bubble);
        messages.appendChild(row);
        scrollToBottom();
    };

    const appendError = (content) => {
        const row = document.createElement('div');
        row.className = 'flex items-start gap-2';

        const bubble = document.createElement('div');
        bubble.className = 'max-w-[85%] rounded-2xl rounded-bl-sm bg-danger-soft/10 px-3.5 py-2.5 text-sm text-danger-soft';
        bubble.textContent = content;

        row.appendChild(bubble);
        messages.appendChild(row);
        scrollToBottom();
    };

    const loadHistory = async () => {
        if (historyLoaded || !conversationId) return;
        historyLoaded = true;

        try {
            const response = await fetch(`/chat/conversations/${conversationId}`, {
                headers: { Accept: 'application/json' },
            });
            if (!response.ok) return;

            const data = await response.json();
            data.messages.forEach((message) => appendMessage(message.role, message.content));
        } catch {
            // A failed rehydrate isn't worth interrupting the visitor with an
            // error bubble for — they still have the static greeting.
        }
    };

    const setOpen = (open) => {
        panel.dataset.open = String(open);
        toggle.setAttribute('aria-expanded', String(open));
        openIcon?.toggleAttribute('hidden', open);
        closeIcon?.toggleAttribute('hidden', !open);

        if (open) {
            input.focus();
            loadHistory();
        }
    };

    toggle.addEventListener('click', () => {
        const willOpen = panel.dataset.open !== 'true';
        if (willOpen) playClick();
        setOpen(willOpen);
    });
    closeButton?.addEventListener('click', () => setOpen(false));

    document.addEventListener('click', (event) => {
        if (panel.dataset.open === 'true' && !root.contains(event.target)) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && panel.dataset.open === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });

    // Enter sends, Shift+Enter inserts a newline.
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        appendMessage('user', message);
        input.value = '';
        input.disabled = true;
        sendButton.disabled = true;
        typing.hidden = false;
        scrollToBottom();

        try {
            const response = await fetch('/chat/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message, conversation_id: conversationId }),
            });

            if (!response.ok) {
                appendError(response.status === 429 ? rateLimitMessage : errorMessage);
                return;
            }

            const data = await response.json();
            conversationId = data.conversation_id;
            localStorage.setItem(STORAGE_KEY, conversationId);
            appendMessage('assistant', data.reply);
        } catch {
            appendError(errorMessage);
        } finally {
            input.disabled = false;
            sendButton.disabled = false;
            typing.hidden = true;
            input.focus();
        }
    });
}

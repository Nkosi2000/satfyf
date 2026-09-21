<div
    class="fixed right-5 bottom-5 z-50 flex flex-col items-end gap-3 sm:right-8 sm:bottom-8"
    data-chatbot
    data-error-message="{{ __("Sorry, something went wrong sending that. Please try again.") }}"
    data-rate-limit-message="{{ __("You're sending messages a little fast — please wait a moment and try again.") }}"
>
    <div
        id="chatbot-panel"
        data-chatbot-panel
        data-open="false"
        role="dialog"
        aria-modal="false"
        aria-label="{{ __('SatfyfBot chat') }}"
        class="pointer-events-none flex h-[32rem] max-h-[75vh] w-[22rem] max-w-[calc(100vw-2.5rem)] origin-bottom-right scale-95 flex-col overflow-hidden rounded-2xl border border-hairline bg-surface opacity-0 transition-[transform,opacity] duration-200 ease-out-strong data-[open=true]:pointer-events-auto data-[open=true]:scale-100 data-[open=true]:opacity-100"
        style="box-shadow: var(--shadow-soft)"
    >
        <div class="hairline-b flex items-center justify-between gap-3 px-4 py-3.5">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-white" style="background-image: var(--gradient-accent)">
                    <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" aria-hidden="true">
                        <path d="M4 5.5c0-.83.67-1.5 1.5-1.5h13c.83 0 1.5.67 1.5 1.5v9c0 .83-.67 1.5-1.5 1.5H9l-4 3.5v-3.5H5.5A1.5 1.5 0 0 1 4 14.5v-9Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-fg">{{ __('SatfyfBot') }}</p>
                    <p class="text-xs text-muted">{{ __('Ask me about SATFYF') }}</p>
                </div>
            </div>
            <button
                type="button"
                data-chatbot-close
                aria-label="{{ __('Close chat') }}"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-muted transition-colors hover:bg-surface-2 hover:text-fg"
            >
                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true">
                    <path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div data-chatbot-messages class="flex-1 space-y-3 overflow-y-auto px-4 py-4">
            <div class="flex items-start gap-2">
                <div class="max-w-[85%] rounded-2xl rounded-bl-sm bg-surface-2 px-3.5 py-2.5 text-sm text-fg">
                    {{ __("Hi, I'm SatfyfBot! Ask me about our programs, events, resources, or how to get involved.") }}
                </div>
            </div>
        </div>

        <div data-chatbot-typing hidden class="px-4 pb-2">
            <div class="flex items-center gap-1 rounded-2xl rounded-bl-sm bg-surface-2 px-3.5 py-2.5" role="status">
                <span class="sr-only">{{ __('SatfyfBot is typing…') }}</span>
                <span class="typing-pulse h-1.5 w-1.5 rounded-full bg-muted" style="animation-delay: 0ms"></span>
                <span class="typing-pulse h-1.5 w-1.5 rounded-full bg-muted" style="animation-delay: 150ms"></span>
                <span class="typing-pulse h-1.5 w-1.5 rounded-full bg-muted" style="animation-delay: 300ms"></span>
            </div>
        </div>

        <form data-chatbot-form class="hairline-t flex items-end gap-2 p-3">
            <label for="chatbot-input" class="sr-only">{{ __('Message') }}</label>
            <textarea
                id="chatbot-input"
                data-chatbot-input
                rows="1"
                maxlength="1000"
                required
                placeholder="{{ __('Type your message…') }}"
                class="max-h-28 flex-1 resize-none rounded-xl border border-hairline-strong bg-surface px-3 py-2 text-sm text-fg placeholder:text-faint focus:border-primary-soft"
            ></textarea>
            <button
                type="submit"
                data-chatbot-send
                aria-label="{{ __('Send message') }}"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-soft text-white transition-opacity hover:opacity-90 disabled:opacity-50"
            >
                <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true">
                    <path d="M17.5 2.5 9 11M17.5 2.5 12 17.5l-3-6.5-6.5-3 15-5.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                </svg>
            </button>
        </form>
    </div>

    <span class="relative flex h-14 w-14 shrink-0">
        <span class="chatbot-ping absolute inset-0 rounded-full bg-primary-soft/40" aria-hidden="true"></span>

        <button
            type="button"
            data-chatbot-toggle
            aria-haspopup="dialog"
            aria-expanded="false"
            aria-controls="chatbot-panel"
            class="press relative flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-primary text-on-accent"
            style="box-shadow: var(--shadow-soft)"
        >
            <span class="sr-only">{{ __('Chat with SatfyfBot') }}</span>
            <svg data-chatbot-icon="open" viewBox="0 0 24 24" fill="none" class="h-6 w-6" aria-hidden="true">
                <path d="M4 5.5c0-.83.67-1.5 1.5-1.5h13c.83 0 1.5.67 1.5 1.5v9c0 .83-.67 1.5-1.5 1.5H9l-4 3.5v-3.5H5.5A1.5 1.5 0 0 1 4 14.5v-9Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            </svg>
            <svg data-chatbot-icon="close" hidden viewBox="0 0 24 24" fill="none" class="h-6 w-6" aria-hidden="true">
                <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </span>
</div>

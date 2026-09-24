// Admin inactivity sign-out driven by real on-page activity (mouse, keys,
// scroll, touch), not just page loads. Activity is shared across admin tabs
// via localStorage, and a throttled heartbeat keeps the server-side idle
// check (SignOutIdleSessions) in step. Once no tab has seen activity for
// the full timeout, this tab navigates to an admin page; the server — whose
// last heartbeat is at least that old — signs the admin out and shows the
// "signed out after 5 minutes of inactivity" message on the login page.
const STORAGE_KEY = 'admin-last-activity';
const HEARTBEAT_EVERY_MS = 60_000;
const STORAGE_WRITE_EVERY_MS = 1_000;
const CHECK_EVERY_MS = 5_000;
// Small margin so the server, which only hears about activity via the
// throttled heartbeat, is guaranteed to agree the session is idle too.
const GRACE_MS = 2_000;
const ACTIVITY_EVENTS = ['mousemove', 'mousedown', 'keydown', 'wheel', 'scroll', 'touchstart', 'input'];

export function initAdminIdle() {
    const { adminIdleTimeout, adminHeartbeatUrl, adminIdleRedirect } = document.body.dataset;
    if (!adminIdleTimeout || !adminHeartbeatUrl || !adminIdleRedirect) return;

    const timeoutMs = Number(adminIdleTimeout) * 1000 + GRACE_MS;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    let lastActivity = Date.now();
    let lastStorageWrite = 0;
    let lastHeartbeat = Date.now(); // this page load already counted server-side
    let signingOut = false;

    const readShared = () => {
        try {
            return Number(localStorage.getItem(STORAGE_KEY)) || 0;
        } catch {
            return 0;
        }
    };

    const writeShared = (time) => {
        try {
            localStorage.setItem(STORAGE_KEY, String(time));
        } catch {
            // Storage blocked — this tab still tracks its own activity.
        }
    };

    const latestActivity = () => Math.max(lastActivity, readShared());

    const signOut = () => {
        if (signingOut) return;
        signingOut = true;
        window.location.assign(adminIdleRedirect);
    };

    const sendHeartbeat = async () => {
        lastHeartbeat = Date.now();

        try {
            const response = await fetch(adminHeartbeatUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                credentials: 'same-origin',
                redirect: 'manual',
            });

            // Anything but 204 means the server already ended the session
            // (idle elsewhere, signed out in another tab, expired token).
            if (response.status !== 204) signOut();
        } catch {
            // Offline or a network blip — try again on the next activity.
        }
    };

    const onActivity = () => {
        const now = Date.now();

        // Coming back after the timeout (e.g. a throttled background tab)
        // must not count as fresh activity and revive an idle session.
        if (now - latestActivity() > timeoutMs) {
            signOut();
            return;
        }

        lastActivity = now;

        if (now - lastStorageWrite > STORAGE_WRITE_EVERY_MS) {
            lastStorageWrite = now;
            writeShared(now);
        }

        if (now - lastHeartbeat > HEARTBEAT_EVERY_MS) {
            sendHeartbeat();
        }
    };

    writeShared(lastActivity);

    ACTIVITY_EVENTS.forEach((type) => {
        document.addEventListener(type, onActivity, { passive: true, capture: true });
    });

    setInterval(() => {
        if (Date.now() - latestActivity() > timeoutMs) signOut();
    }, CHECK_EVERY_MS);
}

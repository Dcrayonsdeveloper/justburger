import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * Auto-recover from CSRF token mismatch (HTTP 419).
 *
 * Long-lived pages (e.g. the POS, which stays open for hours) can end up with
 * a stale token when the session rolls over. On the first 419 for a request,
 * fetch a fresh token, update the meta tag + axios defaults, and retry once so
 * the mismatch heals silently instead of surfacing to the user.
 *
 * This MUST live here — right after window.axios is defined — so it is always
 * installed. It previously sat in an inline <script> that ran before the
 * deferred app.js module executed, so window.axios was undefined and the
 * interceptor threw and never attached.
 */
window.axios.interceptors.response.use(
    (response) => response,
    async (error) => {
        const original = error.config;
        if (error.response?.status === 419 && original && !original._csrfRetried) {
            original._csrfRetried = true;
            try {
                const res = await fetch('/csrf-token', { credentials: 'same-origin' });
                if (res.ok) {
                    const { token: fresh } = await res.json();
                    if (fresh) {
                        const meta = document.head.querySelector('meta[name="csrf-token"]');
                        if (meta) meta.content = fresh;
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = fresh;
                        original.headers = original.headers || {};
                        original.headers['X-CSRF-TOKEN'] = fresh;
                        return window.axios(original);
                    }
                }
            } catch (e) {
                console.error('[CSRF] token refresh failed:', e);
            }
        }
        return Promise.reject(error);
    }
);

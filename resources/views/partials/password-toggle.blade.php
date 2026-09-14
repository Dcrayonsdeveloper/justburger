{{--
    Show/hide control for every password field on the page.

    Included rather than hand-written per form: the password fields live across
    eight standalone HTML documents (the storefront, admin, seller and affiliate
    sign-ins each render their own <html>) plus two layouts, so there is no
    single layout to hang this off. One include, one implementation.

    Deliberately plain JS with no Alpine dependency — admin/auth/login loads
    neither Vite nor Alpine, so anything relying on them would silently do
    nothing there.

    Class names are namespaced. admin/auth/login already defines its own
    .pw-wrap / .pw-toggle in its <head>; sharing those names let this stylesheet
    half-override the page's and drag its button out of position.

    A field is left alone when something already reveals it:
      • Alpine drives its type (:type / x-bind:type)
      • its immediate container already holds a type="button" control
      • it carries data-pw-skip, or sits inside something that does

    Opt a field out with data-pw-skip.
--}}
<style>
    .jbpw-wrap { position: relative; display: block; }
    /* Beats utility classes and inline styles alike, so the text never runs
       under the icon. */
    .jbpw-wrap > input { padding-right: 2.75rem !important; }
    .jbpw-toggle {
        position: absolute; top: 0; right: 0; height: 100%; width: 2.75rem;
        display: flex; align-items: center; justify-content: center;
        padding: 0; margin: 0; border: 0; background: none; cursor: pointer;
        line-height: 0;
        /* A fixed mid grey rather than currentColor: the icon sits on the
           input, but currentColor inherits from the wrapper, so a dark card
           with a pale input (or Chrome's pale autofill background) washed it
           out. This one clears 3:1 against both white and near-black. */
        color: #6b7280;
        transition: color .15s ease;
    }
    .jbpw-toggle:hover { color: #C8102E; }
    .jbpw-toggle:focus-visible { color: #C8102E; outline: 2px solid currentColor; outline-offset: -2px; border-radius: 6px; }
    .jbpw-toggle svg { width: 1.15rem; height: 1.15rem; pointer-events: none; display: block; }
</style>

<script>
(function () {
    'use strict';

    var EYE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5s8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64C20.58 16.49 16.64 19.5 12 19.5s-8.58-3.01-9.96-7.18Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>';
    var EYE_OFF = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.22A10.48 10.48 0 0 0 2.04 11.68a1 1 0 0 0 0 .64C3.42 16.49 7.36 19.5 12 19.5c1.76 0 3.42-.43 4.88-1.2M6.23 6.23A10.45 10.45 0 0 1 12 4.5c4.64 0 8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64 10.53 10.53 0 0 1-4.13 5.19M6.23 6.23 3 3m3.23 3.23 3.65 3.65m7.89 7.89L21 21m-3.23-3.23-3.65-3.65m0 0a3 3 0 1 1-4.24-4.24m4.24 4.24-4.24-4.24"/></svg>';

    function alreadyHandled(input) {
        // Alpine owns this field's type and ships its own control. Writing
        // input.type here would be clobbered on the next re-render anyway.
        if (input.hasAttribute(':type') || input.hasAttribute('x-bind:type')) return true;

        if (input.closest && input.closest('[data-pw-skip]')) return true;

        // A hand-written reveal already sits beside it. Checking for
        // type="button" specifically so a submit button in the same block is
        // not mistaken for one.
        var holder = input.parentElement;
        if (holder && holder.querySelector('button[type="button"]')) return true;

        return false;
    }

    function enhance(input) {
        if (!input || input.dataset.pwToggle === '1') return;
        if (!input.parentNode) return;
        if (alreadyHandled(input)) return;

        input.dataset.pwToggle = '1';

        var wrap = document.createElement('span');
        wrap.className = 'jbpw-wrap';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        var btn = document.createElement('button');
        btn.type = 'button';                 // never submits the form
        btn.className = 'jbpw-toggle';
        btn.tabIndex = -1;                   // keeps tab order password -> submit
        btn.innerHTML = EYE;
        btn.setAttribute('aria-label', 'Show password');
        btn.setAttribute('aria-pressed', 'false');

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var revealing = input.type === 'password';
            input.type = revealing ? 'text' : 'password';
            btn.innerHTML = revealing ? EYE_OFF : EYE;
            btn.setAttribute('aria-label', revealing ? 'Hide password' : 'Show password');
            btn.setAttribute('aria-pressed', revealing ? 'true' : 'false');

            // Put the caret back where the user left it.
            var pos = input.value.length;
            input.focus();
            try { input.setSelectionRange(pos, pos); } catch (err) { /* not all types allow it */ }
        });

        wrap.appendChild(btn);
    }

    function scan(root) {
        var scope = root || document;
        if (!scope.querySelectorAll) return;
        var list = scope.querySelectorAll('input[type="password"]');
        for (var i = 0; i < list.length; i++) enhance(list[i]);
    }

    function start() {
        scan();

        // Sign-in modals and Alpine-rendered step panels arrive after load.
        if (typeof MutationObserver === 'function') {
            new MutationObserver(function (mutations) {
                for (var i = 0; i < mutations.length; i++) {
                    var added = mutations[i].addedNodes;
                    for (var j = 0; j < added.length; j++) {
                        var node = added[j];
                        if (!node || node.nodeType !== 1) continue;
                        if (node.matches && node.matches('input[type="password"]')) enhance(node);
                        // Cheap gate: most added subtrees hold no input at all.
                        else if (node.querySelector && node.querySelector('input')) scan(node);
                    }
                }
            }).observe(document.documentElement, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
</script>

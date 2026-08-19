{{--
    Auto-print till.

    The server cannot reach the shop's printer, so this page does the printing:
    it asks every few seconds what is unprinted, loads each receipt into a hidden
    iframe and calls print(). With Chrome started in kiosk-printing mode that
    goes straight to the default printer with no dialog; without it, Chrome shows
    its usual print box, so nothing breaks — it just is not silent.

    The switch is per-device (localStorage), so the till prints and a manager's
    laptop does not. Switching on stamps a "since" time, so turning it on never
    drags out the back catalogue.
--}}
<div x-data="autoPrintTill()" x-init="boot()" class="inline-flex items-center gap-2">
    <button type="button" @click="toggle()"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold border transition-colors"
            :class="on ? 'bg-emerald-50 border-emerald-300 text-emerald-700' : 'bg-white border-neutral-300 text-neutral-600 hover:border-neutral-400'">
        <span class="w-2 h-2 rounded-full" :class="on ? 'bg-emerald-500' : 'bg-neutral-400'"></span>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6z"/>
        </svg>
        <span x-text="on ? 'Auto-print ON' : 'Auto-print OFF'"></span>
    </button>

    <span x-show="on && note" x-cloak x-text="note" class="text-xs text-neutral-500"></span>
</div>

@once
@push('scripts')
<script>
function autoPrintTill() {
    return {
        on: false,
        note: '',
        since: null,
        timer: null,
        busy: false,
        handled: new Set(),

        boot() {
            this.on = localStorage.getItem('jb_auto_print') === '1';
            this.since = localStorage.getItem('jb_auto_print_since');
            if (this.on) this.start();
            window.addEventListener('beforeunload', () => this.stop());
        },

        toggle() {
            this.on = !this.on;
            localStorage.setItem('jb_auto_print', this.on ? '1' : '0');

            if (this.on) {
                // Only orders from this moment on. Anything earlier was someone
                // else's problem and has presumably already been handed over.
                this.since = new Date().toISOString();
                localStorage.setItem('jb_auto_print_since', this.since);
                this.note = 'watching for new orders…';
                this.start();
            } else {
                this.note = '';
                this.stop();
            }
        },

        start() {
            this.stop();
            this.poll();
            this.timer = setInterval(() => this.poll(), 8000);
        },

        stop() {
            if (this.timer) clearInterval(this.timer);
            this.timer = null;
        },

        async poll() {
            // One receipt at a time: a batch fired at once would interleave jobs
            // on a single thermal printer.
            if (!this.on || this.busy) return;
            this.busy = true;

            try {
                const url = '{{ route('admin.orders.pending-prints') }}'
                    + (this.since ? '?since=' + encodeURIComponent(this.since) : '');
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) throw new Error('lookup failed');

                const { orders } = await res.json();

                for (const order of orders) {
                    if (this.handled.has(order.id)) continue;
                    this.handled.add(order.id);
                    await this.printReceipt(order);
                }

                if (orders.length === 0) this.note = 'watching for new orders…';
            } catch (e) {
                this.note = 'cannot reach the server — retrying';
            } finally {
                this.busy = false;
            }
        },

        printReceipt(order) {
            return new Promise((resolve) => {
                this.note = 'printing ' + order.order_number + '…';

                const frame = document.createElement('iframe');
                frame.style.cssText = 'position:fixed;right:-10000px;bottom:0;width:80mm;height:600px;border:0;';
                frame.src = order.receipt_url;

                const done = async () => {
                    await this.markPrinted(order);
                    frame.remove();
                    this.note = 'printed ' + order.order_number;
                    resolve();
                };

                frame.onload = () => {
                    try {
                        frame.contentWindow.focus();
                        frame.contentWindow.print();
                    } catch (e) {
                        // Printing blocked or cancelled — leave the order unmarked
                        // so it is retried rather than silently lost.
                        this.handled.delete(order.id);
                        frame.remove();
                        this.note = 'could not print ' + order.order_number;
                        return resolve();
                    }
                    setTimeout(done, 1500);
                };

                frame.onerror = () => {
                    this.handled.delete(order.id);
                    frame.remove();
                    resolve();
                };

                document.body.appendChild(frame);
            });
        },

        async markPrinted(order) {
            try {
                await fetch('/admin/orders/' + order.id + '/printed', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'Accept': 'application/json',
                    },
                });
            } catch (e) {
                // Left unmarked on purpose: better a duplicate receipt than a
                // missed order.
                this.handled.delete(order.id);
            }
        },
    };
}
</script>
@endpush
@endonce

{{-- Toppings Selection Modal --}}
<div x-data x-show="$store.toppingsModal.isOpen" x-cloak
     @keydown.escape.window="$store.toppingsModal.close()"
     class="fixed inset-0 z-50" style="font-family:'Barlow',sans-serif;">

    {{-- Backdrop --}}
    <div x-show="$store.toppingsModal.isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.toppingsModal.close()"
         class="absolute inset-0 bg-black/50"></div>

    {{-- Modal Panel --}}
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div x-show="$store.toppingsModal.isOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden max-h-[85vh] flex flex-col">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between" style="border-top:3px solid #C8102E;">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900">Customise Your Order</h3>
                    <p class="text-sm text-neutral-500 mt-0.5" x-text="$store.toppingsModal.productName"></p>
                </div>
                <button @click="$store.toppingsModal.close()" class="p-1.5 text-neutral-400 hover:text-neutral-700 rounded-full hover:bg-neutral-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Loading --}}
            <div x-show="$store.toppingsModal.isLoading" class="flex-1 flex items-center justify-center py-12">
                <svg class="w-8 h-8 animate-spin text-[#C8102E]" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </div>

            {{-- Toppings List --}}
            <div x-show="!$store.toppingsModal.isLoading" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">

                {{-- One list — pre-selected toppings simply arrive ticked --}}
                <div>
                    <h4 class="text-xs font-bold text-neutral-500 uppercase tracking-wider mb-2.5">Choose your toppings</h4>
                    <div class="space-y-1">
                        <template x-for="topping in $store.toppingsModal.allToppings" :key="topping.id">
                            <label class="flex items-center gap-3 py-2 px-3 rounded-lg cursor-pointer transition-colors"
                                   :class="$store.toppingsModal.isSelected(topping.id) ? 'bg-amber-50' : 'bg-neutral-50 hover:bg-neutral-100'"
                                   @click.prevent="$store.toppingsModal.toggle(topping.id)">
                                <input type="checkbox" class="sr-only" :checked="$store.toppingsModal.isSelected(topping.id)">
                                <span class="w-5 h-5 rounded border-2 flex items-center justify-center shrink-0 transition-colors"
                                      :class="$store.toppingsModal.isSelected(topping.id) ? 'bg-[#C8102E] border-[#C8102E]' : 'border-neutral-300 bg-white'">
                                    <svg x-show="$store.toppingsModal.isSelected(topping.id)" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                                <span class="flex-1 text-sm font-medium text-neutral-800" x-text="topping.name"></span>
                                <span class="text-xs font-semibold" :class="topping.price > 0 ? 'text-neutral-600' : 'text-green-600'"
                                      x-text="topping.price > 0 ? '+' + formatCurrency(topping.price) : 'Included'"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div x-show="!$store.toppingsModal.isLoading" class="px-5 py-4 border-t border-neutral-100 bg-neutral-50">
                <div x-show="$store.toppingsModal.toppingsExtra > 0" class="flex justify-between text-sm mb-3">
                    <span class="text-neutral-500">Extra toppings</span>
                    <span class="font-bold text-neutral-800" x-text="'+' + formatCurrency($store.toppingsModal.toppingsExtra)"></span>
                </div>
                <button @click="$store.toppingsModal.confirm()"
                        class="btn-add-order w-full" style="font-size:.85rem;padding:.7rem 1.2rem;">
                    Add to Order
                </button>
            </div>
        </div>
    </div>
</div>

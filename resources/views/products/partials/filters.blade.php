<form action="{{ route('products.index') }}" method="GET"
      style="display:flex;flex-direction:column;gap:.25rem;">

    @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    @php
        $btnBase = 'display:flex;align-items:center;justify-content:space-between;width:100%;padding:.6rem 0;background:none;border:none;cursor:pointer;';
        $lblTitle = 'font-size:.75rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:rgba(255,255,255,.5);';
        $divider = 'height:1px;background:rgba(255,255,255,.07);margin:.25rem 0;';
        $labelCls = 'display:flex;align-items:center;gap:.65rem;cursor:pointer;padding:.3rem 0;';
        $textCls = 'font-size:.85rem;color:rgba(255,255,255,.62);';
    @endphp

    {{-- Categories --}}
    @if($categories->count())
    <div x-data="{ open: true }">
        <button type="button" @click="open = !open" style="{{ $btnBase }}">
            <span style="{{ $lblTitle }}">Category</span>
            <svg style="width:13px;height:13px;color:rgba(255,255,255,.3);transition:transform .15s;" :style="open && 'transform:rotate(180deg)'"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse>
            <div style="display:flex;flex-direction:column;max-height:200px;overflow-y:auto;margin-bottom:.5rem;">
                @foreach($categories as $category)
                <label style="{{ $labelCls }} group">
                    <input type="radio" name="category" value="{{ $category->slug }}"
                           {{ request('category') === $category->slug ? 'checked' : '' }}
                           style="accent-color:#C8102E;width:14px;height:14px;flex-shrink:0;"
                           onchange="this.form.submit()">
                    <span style="{{ $textCls }}"
                          class="group-hover:text-white transition-colors">{{ $category->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    <div style="{{ $divider }}"></div>
    @endif

    {{-- Sub-categories --}}
    @if($subcategories->count())
    <div x-data="{ open: false }">
        <button type="button" @click="open = !open" style="{{ $btnBase }}">
            <span style="{{ $lblTitle }}">Sub-category</span>
            <svg style="width:13px;height:13px;color:rgba(255,255,255,.3);transition:transform .15s;" :style="open && 'transform:rotate(180deg)'"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse>
            <div style="display:flex;flex-direction:column;max-height:200px;overflow-y:auto;margin-bottom:.5rem;">
                @foreach($subcategories as $sub)
                <label style="{{ $labelCls }}">
                    <input type="checkbox" name="subcategory[]" value="{{ $sub->slug }}"
                           {{ in_array($sub->slug, (array) request('subcategory')) ? 'checked' : '' }}
                           style="accent-color:#C8102E;width:14px;height:14px;flex-shrink:0;border-radius:3px;">
                    <span style="{{ $textCls }}">{{ $sub->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>
    <div style="{{ $divider }}"></div>
    @endif

    {{-- Price Range --}}
    <div x-data="{ open: true }">
        <button type="button" @click="open = !open" style="{{ $btnBase }}">
            <span style="{{ $lblTitle }}">Price</span>
            <svg style="width:13px;height:13px;color:rgba(255,255,255,.3);transition:transform .15s;" :style="open && 'transform:rotate(180deg)'"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse>
            <div style="display:flex;align-items:center;gap:.5rem;padding:.25rem 0 .75rem;">
                <input type="number" name="min_price" value="{{ request('min_price') }}"
                       placeholder="Min"
                       style="width:100%;padding:.4rem .6rem;font-size:.82rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:.4rem;color:#fff;outline:none;">
                <span style="color:rgba(255,255,255,.25);font-size:.8rem;">–</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}"
                       placeholder="Max"
                       style="width:100%;padding:.4rem .6rem;font-size:.82rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:.4rem;color:#fff;outline:none;">
            </div>
        </div>
    </div>
    <div style="{{ $divider }}"></div>

    {{-- Rating --}}
    <div x-data="{ open: true }">
        <button type="button" @click="open = !open" style="{{ $btnBase }}">
            <span style="{{ $lblTitle }}">Rating</span>
            <svg style="width:13px;height:13px;color:rgba(255,255,255,.3);transition:transform .15s;" :style="open && 'transform:rotate(180deg)'"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse>
            <div style="display:flex;flex-direction:column;gap:.1rem;margin-bottom:.5rem;">
                @for($i = 4; $i >= 1; $i--)
                <label style="{{ $labelCls }}">
                    <input type="radio" name="rating" value="{{ $i }}"
                           {{ request('rating') == $i ? 'checked' : '' }}
                           style="accent-color:#C8102E;width:14px;height:14px;flex-shrink:0;"
                           onchange="this.form.submit()">
                    <span style="display:flex;align-items:center;gap:2px;">
                        @for($j = 1; $j <= 5; $j++)
                            <svg style="width:12px;height:12px;fill:{{ $j <= $i ? '#D4A017' : 'rgba(255,255,255,.15)' }};" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span style="font-size:.75rem;color:rgba(255,255,255,.4);margin-left:.2rem;">& up</span>
                    </span>
                </label>
                @endfor
            </div>
        </div>
    </div>
    <div style="{{ $divider }}"></div>

    {{-- Availability --}}
    <div x-data="{ open: true }">
        <button type="button" @click="open = !open" style="{{ $btnBase }}">
            <span style="{{ $lblTitle }}">Availability</span>
            <svg style="width:13px;height:13px;color:rgba(255,255,255,.3);transition:transform .15s;" :style="open && 'transform:rotate(180deg)'"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse>
            <div style="display:flex;flex-direction:column;gap:.1rem;margin-bottom:.5rem;">
                <label style="{{ $labelCls }}">
                    <input type="checkbox" name="in_stock" value="1"
                           {{ request('in_stock') ? 'checked' : '' }}
                           style="accent-color:#C8102E;width:14px;height:14px;border-radius:3px;flex-shrink:0;">
                    <span style="{{ $textCls }}">Available now</span>
                </label>
                <label style="{{ $labelCls }}">
                    <input type="checkbox" name="on_sale" value="1"
                           {{ request('on_sale') ? 'checked' : '' }}
                           style="accent-color:#C8102E;width:14px;height:14px;border-radius:3px;flex-shrink:0;">
                    <span style="{{ $textCls }}">Special offer</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Buttons --}}
    <div style="display:flex;gap:.6rem;padding-top:.75rem;">
        <button type="submit"
                style="flex:1;padding:.6rem;background:#C8102E;color:#fff;font-size:.82rem;font-weight:700;border-radius:99px;border:none;cursor:pointer;transition:background .15s;"
                onmouseover="this.style.background='#a50e26'" onmouseout="this.style.background='#C8102E'">
            Apply
        </button>
        <a href="{{ route('products.index') }}"
           style="flex:1;padding:.6rem;text-align:center;font-size:.82rem;font-weight:600;color:rgba(255,255,255,.45);border:1px solid rgba(255,255,255,.12);border-radius:99px;text-decoration:none;transition:all .15s;"
           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,.45)'">
            Reset
        </a>
    </div>
</form>

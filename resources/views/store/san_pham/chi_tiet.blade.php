@extends('layouts.app')
@section('title', $product->ten . ' — E-Shop')

@php
    use Illuminate\Support\Js;
    $bienTheJson = $product->variants->map(function ($v) use ($product) {
        $imgs = $v->images->map(fn ($img) => url_anh_public($img->hinh_anh))->filter()->values()->all();

        return [
            'id' => $v->id,
            'so_luong' => (int) $v->so_luong,
            'imgs' => $imgs,
            'nhan' => collect($v->gia_tri_bien_the)->map(fn ($val, $key) => $key.': '.$val)->implode(' · ') ?: 'Biến thể #'.$v->id,
            'gia_ban' => $v->gia_ban_hien_thi($product),
            'co_sale' => $v->co_hien_thi_nhan_sale($product),
            'gia_pay' => $v->gia_thanh_toan($product),
        ];
    })->values()->all();
@endphp

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-12">
    <nav class="text-sm text-slate-500 mb-8 flex items-center gap-2 flex-wrap">
        <a href="/" class="hover:text-sky-600 transition-colors">Trang chủ</a>
        <span>/</span>
        @if($product->category)
        <a href="/danh_muc/{{ $product->category_id }}" class="hover:text-sky-600 transition-colors">{{ $product->category->ten }}</a>
        <span>/</span>
        @endif
        <span class="text-slate-800 font-medium">{{ $product->ten }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14"
         x-data="chitietSanPham({ bienThe: {{ Js::from($bienTheJson) }} })">
        <div class="space-y-4">
            <div class="rounded-[2rem] overflow-hidden bg-slate-100 shadow-2xl shadow-slate-200/60 ring-1 ring-white min-h-[280px] max-h-[520px] aspect-square flex items-center justify-center p-0 relative">
                <img x-show="v.imgs && v.imgs.length"
                     :src="v.imgs.length ? v.imgs[Math.min(activeAnh, v.imgs.length - 1)] : ''"
                     alt=""
                     class="w-full h-full object-contain transition-all duration-500 ease-out" style="aspect-ratio: 1/1;"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">
                <div x-show="!v.imgs || !v.imgs.length" class="absolute inset-0 flex items-center justify-center text-slate-400 text-sm font-medium">
                    Chưa có hình cho biến thể này
                </div>
            </div>
            <div class="flex gap-3 flex-wrap justify-center lg:justify-start" x-show="v.imgs && v.imgs.length > 1">
                <template x-for="(img, i) in v.imgs" :key="i">
                    <button type="button"
                            @click="activeAnh = i"
                            :class="activeAnh === i ? 'ring-2 ring-sky-500 scale-105' : 'ring-1 ring-slate-200 opacity-80 hover:opacity-100'"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 bg-white flex items-center justify-center p-0.5">
                        <img :src="img" class="max-w-full max-h-full object-contain rounded-xl" alt="">
                    </button>
                </template>
            </div>
            <p class="text-center lg:text-left text-xs text-slate-400" x-show="v.imgs && v.imgs.length > 1">Ảnh tự chuyển sau vài giây — nhấn thumbnail để chọn.</p>
        </div>

        <div class="lg:pt-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight mb-4">{{ $product->ten }}</h1>

            <div class="mb-6 min-h-[3.5rem]" x-show="v && v.id">
                <div x-show="v.co_sale" class="flex items-baseline gap-3 flex-wrap" style="display: none;">
                    <span class="line-through text-slate-400 text-lg" x-text="formatGia(v.gia_ban)"></span>
                    <span class="text-4xl font-bold text-sky-600" x-text="formatGia(v.gia_pay)"></span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-gradient-to-r from-rose-500 to-orange-500">Sale</span>
                </div>
                <div x-show="!v.co_sale" style="display: none;">
                    <span class="text-4xl font-bold text-slate-900" x-text="formatGia(v.gia_pay)"></span>
                </div>
            </div>

            <div class="prose prose-slate max-w-none mb-8 text-slate-600 leading-relaxed">{!! nl2br(e($product->mo_ta)) !!}</div>

            <div class="mb-4">
                <p class="text-sm font-bold text-slate-800 mb-2">Chọn biến thể</p>
                <p class="text-xs text-slate-500 mb-3">Nhấn vào biến thể để xem ảnh và giá tương ứng. Hết hàng sẽ bị mờ và không thêm được vào giỏ.</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(bt, i) in bienThe" :key="bt.id">
                        <button type="button"
                                @click="chonBienThe(i)"
                                :disabled="bt.so_luong === 0"
                                :class="[
                                    chiSo === i ? 'ring-2 ring-sky-500 bg-sky-50 text-sky-900' : 'ring-1 ring-slate-200 bg-white text-slate-700 hover:ring-sky-300 hover:bg-sky-50/80',
                                    bt.so_luong === 0 ? 'opacity-45 cursor-not-allowed' : ''
                                ]"
                                class="px-4 py-2.5 rounded-2xl text-sm font-semibold transition-all duration-300 hover:scale-[1.02] text-left">
                            <span x-text="bt.nhan"></span>
                            <span class="block text-xs font-normal mt-0.5 opacity-80" x-text="'Tồn: ' + bt.so_luong"></span>
                            <span class="block text-xs font-bold text-sky-700 mt-0.5" x-text="formatGia(bt.gia_pay)"></span>
                        </button>
                    </template>
                </div>
            </div>

            @auth
            <form method="POST" action="/gio_hang/them" class="rounded-3xl border border-slate-200/80 bg-white/90 backdrop-blur p-6 shadow-xl shadow-sky-100/30 space-y-5">
                @csrf
                <input type="hidden" name="product_variant_id" :value="v.id">
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Số lượng</label>
                    <input type="number" name="so_luong" value="1" min="1" :max="v.so_luong > 0 ? v.so_luong : 1" class="w-32 rounded-2xl border-slate-200 px-4 py-3 font-semibold focus:ring-2 focus:ring-sky-400 transition">
                </div>
                <button type="submit"
                        class="store-ocean-btn w-full sm:w-auto gap-2 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:transform-none"
                        :disabled="!coTheMua || !bienThe.length">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Thêm vào giỏ hàng
                </button>
            </form>
            @else
            <div class="rounded-3xl border border-dashed border-sky-200 bg-sky-50/50 p-8 text-center">
                <p class="text-slate-600 mb-4 font-medium">Đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
                <a href="/dang_nhap" class="store-ocean-btn no-underline px-8">Đăng nhập</a>
            </div>
            @endauth
        </div>
    </div>

    @isset($goiY)
    @if($goiY->isNotEmpty())
    <section class="mt-16 lg:mt-20 pt-10 border-t border-slate-200/80">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Có thể bạn thích</h2>
        <p class="text-slate-500 text-sm mb-8">Cùng danh mục và sản phẩm tương tự.</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach($goiY as $g)
            @php
                $thumb = $g->variants->first()?->images->first()?->hinh_anh;
                $u = $thumb ? url_anh_public($thumb) : '';
            @endphp
            <a href="/san_pham/{{ $g->id }}" class="group rounded-2xl bg-white border border-slate-100 p-4 shadow-md hover:shadow-lg hover:border-indigo-400 transition flex flex-col items-center text-center min-h-[220px] max-w-[210px] mx-auto">
                <div class="w-full aspect-square rounded-xl bg-slate-100 mb-2 flex items-center justify-center overflow-hidden" style="height:130px;">
                    @if($u)
                    <img src="{{ $u }}" alt="" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" style="aspect-ratio:1/1;">
                    @else
                    <span class="text-[13px] text-slate-400">Ảnh</span>
                    @endif
                </div>
                <div class="flex-1 flex flex-col justify-center">
                    <p class="text-base font-extrabold text-indigo-700 leading-tight mb-1 group-hover:text-pink-600 line-clamp-2" style="letter-spacing:0.01em;">{{ $g->ten }}</p>
                    <p class="text-base font-bold text-pink-600">{{ $g->khoang_gia_hien_thi() }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
    @endisset
</div>
@endsection

@push('scripts')
<script>
function chitietSanPham(config) {
    return {
        bienThe: config.bienThe || [],
        chiSo: 0,
        activeAnh: 0,
        _slideTimer: null,
        formatGia(n) {
            return new Intl.NumberFormat('vi-VN').format(Math.round(Number(n) || 0)) + 'đ';
        },
        init() {
            const i = this.bienThe.findIndex(b => b.so_luong > 0);
            if (i >= 0) this.chiSo = i;
            this._slideTimer = setInterval(() => {
                const cur = this.bienThe[this.chiSo];
                if (cur && cur.imgs && cur.imgs.length > 1) {
                    this.activeAnh = (this.activeAnh + 1) % cur.imgs.length;
                }
            }, 4500);
        },
        chonBienThe(i) {
            if (this.bienThe[i].so_luong === 0) return;
            this.chiSo = i;
            this.activeAnh = 0;
        },
        get v() {
            return this.bienThe[this.chiSo] || { id: '', imgs: [], so_luong: 0, nhan: '', gia_ban: 0, co_sale: false, gia_pay: 0 };
        },
        get coTheMua() {
            return this.v && this.v.id && this.v.so_luong > 0;
        },
    };
}
</script>
@endpush

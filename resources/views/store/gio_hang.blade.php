@extends('layouts.app')
@section('title', 'Giỏ hàng — E-Shop')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-12 max-w-4xl">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Giỏ hàng</h1>
        <p class="mt-2 text-slate-600 text-sm"><a href="/" class="text-sky-700 font-semibold underline hover:text-sky-900 transition-colors">← Tiếp tục mua</a></p>
    </header>

    @if($items->isEmpty())
    <div class="store-filter-card p-12 text-center">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-100 text-sky-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <p class="text-lg font-semibold text-slate-800">Giỏ hàng trống</p>
        <p class="text-slate-500 text-sm mt-1 mb-6">Thêm sản phẩm từ cửa hàng.</p>
        <a href="/" class="store-ocean-btn no-underline">Cửa hàng</a>
    </div>
    @else
    @php $tong = 0; @endphp

    <ul class="space-y-3 mb-8 list-none p-0 m-0">
        @foreach($items as $item)
        @php
            $p = $item->variant->product;
            $dongGia = $item->variant->gia_thanh_toan($p);
            $imgPath = $item->variant->images->first()?->hinh_anh;
            $imgUrl = $imgPath ? url_anh_public($imgPath) : '';
            if ($imgUrl === '') {
                $fallback = $p->variants->first()?->images->first()?->hinh_anh;
                $imgUrl = $fallback ? url_anh_public($fallback) : '';
            }
            $tong += $dongGia * $item->so_luong;
            $maxSl = max(1, (int) $item->variant->so_luong);
        @endphp
        <li class="store-filter-card store-cart-row p-4 sm:p-5">
            <a href="/san_pham/{{ $item->variant->product_id }}" class="store-cart-thumb shrink-0 rounded-2xl bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200 hover:border-sky-300 hover:shadow-md transition-all duration-300">
                @if($imgUrl)
                <img src="{{ $imgUrl }}" alt="" class="max-w-full max-h-full object-contain">
                @else
                <span class="text-xs text-slate-400 px-2 text-center">Chưa có ảnh</span>
                @endif
            </a>
            <div class="min-w-0">
                <a href="/san_pham/{{ $item->variant->product_id }}" class="text-base font-bold text-slate-900 hover:text-sky-700 transition-colors">{{ $p->ten }}</a>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    @foreach($item->variant->gia_tri_bien_the as $k=>$v)
                        <span class="text-[11px] px-2 py-0.5 rounded-lg bg-sky-50 text-sky-800 border border-sky-100 font-medium">{{ $k }}: {{ $v }}</span>
                    @endforeach
                </div>
                <p class="mt-2 text-sm text-slate-600">Đơn giá <span class="font-bold text-slate-900 tabular-nums">{{ number_format($dongGia) }}đ</span></p>
            </div>
            <div class="store-cart-aside w-full sm:w-auto">
                <div class="store-qty-group">
                    <form method="POST" action="/gio_hang/cap_nhat" class="inline m-0">@csrf
                        <input type="hidden" name="items[{{ $item->id }}]" value="{{ max(1, $item->so_luong - 1) }}">
                        <button type="submit" class="store-qty-btn" {{ $item->so_luong <= 1 ? 'disabled' : '' }} title="Giảm" aria-label="Giảm">@include('admin.partials.icon', ['name' => 'minus', 'class' => 'w-5 h-5'])</button>
                    </form>
                    <span class="w-9 text-center text-sm font-bold tabular-nums text-slate-900">{{ $item->so_luong }}</span>
                    <form method="POST" action="/gio_hang/cap_nhat" class="inline m-0">@csrf
                        <input type="hidden" name="items[{{ $item->id }}]" value="{{ min($maxSl, $item->so_luong + 1) }}">
                        <button type="submit" class="store-qty-btn" {{ $item->so_luong >= $maxSl ? 'disabled' : '' }} title="Tăng" aria-label="Tăng">@include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])</button>
                    </form>
                </div>
                <div class="flex flex-wrap items-center gap-3 justify-between sm:justify-end w-full sm:flex-col sm:items-end">
                    <div class="text-left sm:text-right">
                        <p class="text-[11px] text-slate-500 font-semibold uppercase tracking-wide">Tạm tính</p>
                        <p class="text-lg font-bold text-sky-700 tabular-nums">{{ number_format($dongGia * $item->so_luong) }}đ</p>
                    </div>
                    <form action="/gio_hang/xoa/{{ $item->id }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Xóa khỏi giỏ?')" class="store-icon-danger" title="Xóa dòng" aria-label="Xóa">
                            @include('admin.partials.icon', ['name' => 'trash', 'class' => 'w-5 h-5'])
                        </button>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="store-summary-bar rounded-2xl bg-gradient-to-br from-sky-700 to-sky-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-xl shadow-sky-900/20">
        <div>
            <p class="store-summary-label text-sky-200 text-sm font-medium">Tổng cộng</p>
            <p class="store-summary-amount text-3xl font-bold tabular-nums mt-1">{{ number_format($tong) }}đ</p>
        </div>
        <a href="/" class="store-cta-light shrink-0 inline-flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            Tiếp tục mua
        </a>
    </div>
    @endif

    @if(isset($goiY) && $goiY->isNotEmpty())
    <section class="mt-14">
        <h2 class="text-xl font-bold text-slate-900 mb-1">Có thể bạn thích</h2>
        <p class="text-sm text-slate-500 mb-5">Gợi ý theo danh mục.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($goiY as $sp)
            @php
                $thumb = $sp->variants->first()?->images->first()?->hinh_anh;
                $thumbUrl = $thumb ? url_anh_public($thumb) : '';
                $bv = $sp->variants->firstWhere('so_luong', '>', 0) ?? $sp->variants->first();
            @endphp
            <div class="store-filter-card p-4 flex gap-4 hover:shadow-lg hover:border-sky-200/80 transition-all duration-300">
                <a href="/san_pham/{{ $sp->id }}" class="w-24 h-24 shrink-0 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-100 hover:scale-[1.02] transition-transform">
                    @if($thumbUrl)
                    <img src="{{ $thumbUrl }}" alt="" class="max-w-full max-h-full object-contain">
                    @endif
                </a>
                <div class="flex-1 min-w-0 flex flex-col">
                    <a href="/san_pham/{{ $sp->id }}" class="font-bold text-slate-900 hover:text-sky-700 text-sm line-clamp-2 transition-colors">{{ $sp->ten }}</a>
                    <p class="text-sm font-semibold text-sky-700 mt-1">{{ $sp->khoang_gia_hien_thi() }}</p>
                    <div class="mt-auto pt-3 flex flex-wrap gap-2">
                        @auth
                        @if($bv && $bv->so_luong > 0)
                        <form method="POST" action="/gio_hang/them" class="inline m-0">
                            @csrf
                            <input type="hidden" name="product_variant_id" value="{{ $bv->id }}">
                            <input type="hidden" name="so_luong" value="1">
                            <button type="submit" class="store-ocean-icon-btn" title="Thêm nhanh" aria-label="Thêm nhanh">
                                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                            </button>
                        </form>
                        @endif
                        @endauth
                        <a href="/san_pham/{{ $sp->id }}" class="store-ghost-icon-btn" title="Chi tiết" aria-label="Chi tiết">
                            @include('admin.partials.icon', ['name' => 'eye', 'class' => 'w-5 h-5'])
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

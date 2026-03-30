@extends('admin.layouts.app')
@section('title', 'Sửa sản phẩm')
@section('breadcrumb', 'Sản phẩm')
@section('page_title', 'Sửa: '.$product->ten)

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
    $loaiBt = $product->category?->variantTypes ?? collect();
@endphp
<div class="max-w-4xl mx-auto space-y-6 admin-fade-up" x-data="{ formThemIds: [Date.now()] }">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="/quan_ly_san_pham" class="admin-btn-ghost text-sm">← Danh sách sản phẩm</a>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Thông tin sản phẩm</h2>
        <form method="POST" action="/quan_ly_san_pham/sua/{{ $product->id }}" class="space-y-4">
            @csrf
            <input type="text" name="ten" class="{{ $inp }}" value="{{ $product->ten }}" required>
            <textarea name="mo_ta" rows="3" class="{{ $inp }}">{{ $product->mo_ta }}</textarea>
            <select name="category_id" class="{{ $inp }}" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($product->category_id == $cat->id)>{{ $cat->ten }}</option>
                @endforeach
            </select>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="number" name="gia_nhap" class="{{ $inp }}" value="{{ $product->gia_nhap }}" required>
                <input type="number" name="gia_ban" class="{{ $inp }}" value="{{ $product->gia_ban }}" required>
                <input type="number" name="gia_sale" class="{{ $inp }}" value="{{ $product->gia_sale }}" placeholder="Sale">
            </div>
            <button type="submit" class="admin-btn-primary">Lưu thông tin sản phẩm</button>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3">
            <h2 class="text-lg font-bold text-slate-900">Biến thể ({{ $product->variants->count() }})</h2>
            @if($loaiBt->isNotEmpty())
            <button type="button" @click="formThemIds.push(Date.now())" class="admin-btn-primary text-xs">+ Thêm form biến thể</button>
            @endif
        </div>
        <div class="p-6 space-y-4">
            @if($loaiBt->isEmpty())
                <p class="text-sm text-amber-800 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">Danh mục chưa có loại biến thể — <a href="/quan_ly_danh_muc" class="underline font-semibold">cập nhật danh mục</a>.</p>
            @endif

            @foreach($product->variants as $bt)
            <details class="group rounded-2xl border border-slate-200 bg-slate-50/50 open:bg-white open:shadow-md transition-all">
                <summary class="cursor-pointer list-none px-4 py-3 flex flex-wrap items-center justify-between gap-2 font-semibold text-slate-800">
                    <span class="flex flex-wrap gap-2 items-center">
                        <span class="text-xs font-mono text-slate-500">#{{ $bt->id }}</span>
                        @foreach($bt->gia_tri_bien_the as $k => $v)
                            <span class="text-xs px-2 py-1 rounded-lg bg-sky-100 text-sky-800">{{ $k }}: {{ $v }}</span>
                        @endforeach
                        <span class="text-xs text-slate-500">Tồn: {{ $bt->so_luong }}</span>
                    </span>
                    <span class="text-xs text-sky-600 group-open:hidden">Mở chỉnh sửa ▾</span>
                    <span class="text-xs text-sky-600 hidden group-open:inline">Thu gọn ▴</span>
                </summary>
                <div class="px-4 pb-4 pt-0 border-t border-slate-100">
                    <form method="POST" action="/quan_ly_bien_the/sua/{{ $bt->id }}" enctype="multipart/form-data" class="space-y-3 mt-4">
                        @csrf
                        @foreach($bt->gia_tri_bien_the as $k => $v)
                            <div>
                                <label class="text-xs font-bold text-slate-500">{{ $k }}</label>
                                <input type="text" name="gia_tri_bien_the[{{ $k }}]" class="{{ $inp }}" value="{{ $v }}" required>
                            </div>
                        @endforeach
                        <input type="number" name="so_luong" class="{{ $inp }}" value="{{ $bt->so_luong }}" min="0" required>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá bán riêng</label>
                                <input type="number" name="gia_ban" class="{{ $inp }}" min="0" step="1" placeholder="Trống = SP" value="{{ old('gia_ban', $bt->gia_ban) }}">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá sale riêng</label>
                                <input type="number" name="gia_sale" class="{{ $inp }}" min="0" step="1" placeholder="Tùy chọn" value="{{ old('gia_sale', $bt->gia_sale) }}">
                            </div>
                        </div>
                        @if($bt->images->isNotEmpty())
                            <p class="text-xs font-bold text-slate-500">Xóa ảnh</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($bt->images as $img)
                                    <label class="flex items-center gap-1 text-xs border rounded-xl px-2 py-1 cursor-pointer">
                                        <input type="checkbox" name="xoa_hinh_anh[]" value="{{ $img->id }}" class="rounded text-sky-600">
                                        <img src="{{ url_anh_public($img->hinh_anh) }}" class="w-10 h-10 object-cover rounded-lg" alt="">
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <label class="text-xs font-bold text-slate-500">Thêm ảnh</label>
                            <input type="file" name="hinh_anh[]" class="{{ $inp }}" accept="image/*" multiple>
                        </div>
                        <button type="submit" class="admin-btn-primary text-xs">Lưu biến thể</button>
                    </form>
                    <form method="POST" action="/quan_ly_bien_the/xoa/{{ $bt->id }}" class="mt-2 inline" onsubmit="return confirm('Xóa biến thể này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn-ghost text-xs text-rose-700 border-rose-200">Xóa biến thể</button>
                    </form>
                </div>
            </details>
            @endforeach

            @if($product->variants->isEmpty())
                <p class="text-sm text-slate-500">Chưa có biến thể. Dùng form bên dưới để thêm.</p>
            @endif

            @if($loaiBt->isNotEmpty())
            <template x-for="fid in formThemIds" :key="fid">
                <div class="rounded-2xl border-2 border-dashed border-sky-200 bg-sky-50/30 p-4 space-y-3">
                    <p class="text-xs font-bold text-sky-800 uppercase">Thêm biến thể mới</p>
                    <form method="POST" action="/quan_ly_bien_the/them" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($loaiBt as $loai)
                            <div>
                                <label class="text-xs font-bold text-slate-600">{{ $loai->ten }}</label>
                                <input type="text" name="gia_tri_bien_the[{{ $loai->ten }}]" class="{{ $inp }}" required placeholder="VD: Đỏ, XL">
                            </div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs font-bold text-slate-500">Tồn</label>
                                <input type="number" name="so_luong" class="{{ $inp }}" min="0" value="0" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá bán riêng</label>
                                <input type="number" name="gia_ban" class="{{ $inp }}" min="0" step="1" placeholder="Trống = SP">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá sale riêng</label>
                                <input type="number" name="gia_sale" class="{{ $inp }}" min="0" step="1" placeholder="Tùy chọn">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Ảnh</label>
                                <input type="file" name="hinh_anh[]" class="{{ $inp }}" accept="image/*" multiple>
                            </div>
                        </div>
                        <button type="submit" class="admin-btn-primary text-xs">Lưu biến thể mới</button>
                    </form>
                </div>
            </template>
            @endif
        </div>
    </div>
</div>
@endsection

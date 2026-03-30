@extends('admin.layouts.app')
@section('title', 'Thêm sản phẩm')
@section('breadcrumb', 'Sản phẩm')
@section('page_title', 'Thêm sản phẩm mới')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-4xl mx-auto space-y-6 admin-fade-up"
     x-data="formThemSanPham({{ old('category_id') !== null && old('category_id') !== '' ? (int) old('category_id') : 'null' }})"
     x-init="if (categoryId) { $nextTick(() => taiLoai()); }">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="/quan_ly_san_pham" class="admin-btn-ghost text-sm">← Quay lại danh sách</a>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-1">Thông tin sản phẩm</h2>
        <p class="text-sm text-slate-500 mb-6">Chọn danh mục trước — hệ thống hiển thị đúng các thuộc tính biến thể. Biến thể đầu tiên bắt buộc; bấm «Thêm biến thể» để nhập thêm.</p>

        <form method="POST" action="/quan_ly_san_pham/them" enctype="multipart/form-data" class="space-y-8" @submit="if (!categoryId) { $event.preventDefault(); alert('Vui lòng chọn danh mục.'); }">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tên sản phẩm</label>
                    <input type="text" name="ten" class="{{ $inp }}" required value="{{ old('ten') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mô tả</label>
                    <textarea name="mo_ta" rows="3" class="{{ $inp }}">{{ old('mo_ta') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Danh mục</label>
                    <select name="category_id" class="{{ $inp }}" required x-model.number="categoryId" @change="taiLoai(); variants = [{ key: Date.now() }];">
                        <option value="">— Chọn danh mục —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->ten }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-slate-500">Quy tắc giá sản phẩm: <strong>giá nhập &lt; giá sale ≤ giá bán</strong>. Để trống giá sale = dùng giá bán.</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá nhập</label>
                        <input type="number" name="gia_nhap" class="{{ $inp }}" min="0" step="1" required value="{{ old('gia_nhap') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá bán</label>
                        <input type="number" name="gia_ban" class="{{ $inp }}" min="0" step="1" required value="{{ old('gia_ban') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá sale</label>
                        <input type="number" name="gia_sale" class="{{ $inp }}" min="0" step="1" placeholder="Trống = giá bán" value="{{ old('gia_sale') }}">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-sky-100 bg-sky-50/40 p-5 space-y-4" x-show="dangTai" x-cloak>
                <p class="text-sm font-medium text-sky-800">Đang tải loại biến thể…</p>
            </div>

            <div class="space-y-4" x-show="categoryId && !dangTai && loai.length === 0" x-cloak>
                <p class="text-sm text-amber-800 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">Danh mục này chưa gắn loại biến thể. <a href="/quan_ly_danh_muc" class="font-semibold underline">Cập nhật danh mục</a> trước khi thêm sản phẩm.</p>
            </div>

            <div class="space-y-4" x-show="loai.length && !dangTai" x-cloak>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h3 class="text-base font-bold text-slate-900">Biến thể</h3>
                    <button type="button" @click="themDong()" class="admin-btn-ghost text-xs">+ Thêm biến thể</button>
                </div>

                <template x-for="(row, index) in variants" :key="row.key">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5 space-y-4">
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-xs font-bold uppercase text-slate-500">Biến thể <span x-text="index + 1"></span></span>
                            <button type="button" class="text-xs font-semibold text-rose-600 hover:underline" x-show="variants.length > 1" @click="xoaDong(index)">Xóa dòng</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <template x-for="t in loai" :key="t.id">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1" x-text="t.ten"></label>
                                    <input type="text" class="{{ $inp }}" :name="'variants['+index+'][gia_tri_bien_the]['+t.ten+']'" placeholder="VD: Đen, M" required>
                                </div>
                            </template>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs font-bold text-slate-500">Tồn kho</label>
                                <input type="number" class="{{ $inp }}" :name="'variants['+index+'][so_luong]'" min="0" value="0" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá bán riêng</label>
                                <input type="number" class="{{ $inp }}" :name="'variants['+index+'][gia_ban]'" min="0" step="1" placeholder="Trống = SP">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500">Giá sale riêng</label>
                                <input type="number" class="{{ $inp }}" :name="'variants['+index+'][gia_sale]'" min="0" step="1" placeholder="Tùy chọn">
                            </div>
                            <div class="sm:col-span-1">
                                <label class="text-xs font-bold text-slate-500">Ảnh (nhiều file)</label>
                                <input type="file" class="{{ $inp }}" :name="'variants['+index+'][hinh_anh][]'" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="admin-btn-primary" x-bind:disabled="!categoryId || !loai.length || dangTai">Lưu sản phẩm</button>
                <a href="/quan_ly_san_pham" class="admin-btn-ghost">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('formThemSanPham', (initialCat) => ({
        categoryId: initialCat != null ? initialCat : '',
        loai: [],
        dangTai: false,
        variants: [{ key: Date.now() }],
        async taiLoai() {
            this.loai = [];
            if (!this.categoryId) return;
            this.dangTai = true;
            try {
                const r = await fetch('/quan_ly_bien_the/loai_theo_danh_muc/' + this.categoryId, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const j = await r.json();
                this.loai = j.loai_bien_the || [];
            } catch (e) {
                this.loai = [];
            } finally {
                this.dangTai = false;
            }
        },
        themDong() {
            this.variants.push({ key: Date.now() });
        },
        xoaDong(i) {
            if (this.variants.length > 1) this.variants.splice(i, 1);
        },
    }));
});
</script>
@endpush

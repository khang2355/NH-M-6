@extends('admin.layouts.app')
@section('title', 'Biến thể sản phẩm')
@section('breadcrumb', 'Biến thể')
@section('page_title', 'Biến thể')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-6xl mx-auto space-y-8 admin-fade-up" x-data="formBienTheThem()">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-2">Thêm biến thể</h2>
        <p class="text-sm text-slate-500 mb-4">Chọn sản phẩm — nhập thuộc tính — upload nhiều ảnh.</p>
        <form method="POST" action="/quan_ly_bien_the/them" enctype="multipart/form-data" class="space-y-4" @submit="if (!productId) { $event.preventDefault(); alert('Chọn sản phẩm'); }">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sản phẩm</label>
                <select name="product_id" class="{{ $inp }}" x-model="productId" @change="taiLoaiBienThe()" required>
                    <option value="">— Chọn —</option>
                    @foreach($sanPhams as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->ten }} ({{ $sp->category->ten ?? '?' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="rounded-2xl border border-dashed border-sky-200 bg-sky-50/40 p-4 space-y-3" x-show="dangTai" x-cloak>
                <p class="text-xs text-sky-800 font-medium">Đang tải loại biến thể…</p>
            </div>
            <div class="space-y-3" x-show="loai.length && !dangTai" x-cloak>
                <template x-for="t in loai" :key="t.id">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1" x-text="t.ten"></label>
                        <input type="text" class="{{ $inp }}" :name="'gia_tri_bien_the[' + t.ten + ']'" placeholder="Giá trị" required>
                    </div>
                </template>
            </div>
            <p class="text-sm text-amber-700 bg-amber-50 border border-amber-100 rounded-2xl px-3 py-2" x-show="productId && !dangTai && loai.length === 0" x-cloak>
                Danh mục của sản phẩm chưa gắn loại biến thể. Hãy cập nhật tại <a href="/quan_ly_danh_muc" class="underline font-semibold">Quản lý danh mục</a>.
            </p>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Số lượng tồn</label>
                <input type="number" name="so_luong" class="{{ $inp }} max-w-xs" min="0" value="0" required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá bán riêng</label>
                    <input type="number" name="gia_ban" class="{{ $inp }}" min="0" step="1" placeholder="Trống = giá SP">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá sale riêng</label>
                    <input type="number" name="gia_sale" class="{{ $inp }}" min="0" step="1" placeholder="Tùy chọn">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Ảnh biến thể (nhiều file)</label>
                <input type="file" name="hinh_anh[]" class="{{ $inp }}" accept="image/*" multiple>
            </div>
            <button type="submit" class="admin-btn-compact" :disabled="!productId || loai.length === 0">
                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                Thêm
            </button>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 font-bold">Danh sách biến thể</div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Sản phẩm</th>
                        <th class="px-4 py-3">Thuộc tính</th>
                        <th class="px-4 py-3">Ảnh</th>
                        <th class="px-4 py-3">Tồn</th>
                        <th class="px-4 py-3 w-56">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($bienThes as $bt)
                    <tr class="hover:bg-sky-50/40 transition-colors align-top">
                        <td class="px-4 py-3 font-mono text-slate-500">{{ $bt->id }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $bt->product->ten ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @foreach($bt->gia_tri_bien_the as $k => $v)
                                <span class="inline-flex mr-1 mb-1 px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800 text-xs">{{ $k }}: {{ $v }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1 max-w-[200px]">
                                @forelse($bt->images as $img)
                                    <img src="{{ url_anh_public($img->hinh_anh) }}" class="w-12 h-12 object-cover rounded-xl ring-1 ring-slate-200 hover:scale-110 transition-transform" alt="">
                                @empty
                                    <span class="text-slate-400 text-xs">Chưa có ảnh</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $bt->so_luong }}</td>
                        <td class="px-4 py-3 relative">
                            <div class="flex flex-wrap items-center gap-2 justify-end">
                            <details class="group relative">
                                <summary class="admin-icon-btn admin-icon-btn--indigo cursor-pointer list-none" title="Sửa biến thể">
                                    @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                                </summary>
                                <div class="absolute right-0 z-30 mt-2 w-[min(100vw-2rem,22rem)] p-4 rounded-2xl bg-white border border-slate-200 shadow-2xl shadow-indigo-200/30 space-y-3 text-left">
                                    <form method="POST" action="/quan_ly_bien_the/sua/{{ $bt->id }}" enctype="multipart/form-data" class="space-y-3">
                                        @csrf
                                        @foreach($bt->gia_tri_bien_the as $k => $v)
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 mb-1">{{ $k }}</label>
                                                <input type="text" name="gia_tri_bien_the[{{ $k }}]" class="{{ $inp }}" value="{{ $v }}" required>
                                            </div>
                                        @endforeach
                                        <input type="number" name="so_luong" class="{{ $inp }}" value="{{ $bt->so_luong }}" min="0" required>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 mb-1">Giá bán riêng</label>
                                                <input type="number" name="gia_ban" class="{{ $inp }}" min="0" step="1" placeholder="Trống = SP" value="{{ old('gia_ban', $bt->gia_ban) }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 mb-1">Giá sale riêng</label>
                                                <input type="number" name="gia_sale" class="{{ $inp }}" min="0" step="1" placeholder="Tùy chọn" value="{{ old('gia_sale', $bt->gia_sale) }}">
                                            </div>
                                        </div>
                                        @if($bt->images->isNotEmpty())
                                            <div class="text-xs font-bold text-slate-500 uppercase">Xóa ảnh đã có</div>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($bt->images as $img)
                                                    <label class="flex items-center gap-1 text-xs bg-white border border-slate-200 rounded-xl px-2 py-1 cursor-pointer hover:border-rose-200">
                                                        <input type="checkbox" name="xoa_hinh_anh[]" value="{{ $img->id }}">
                                                        <img src="{{ url_anh_public($img->hinh_anh) }}" class="w-8 h-8 object-cover rounded-lg" alt="">
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Thêm ảnh mới</label>
                                            <input type="file" name="hinh_anh[]" class="{{ $inp }}" accept="image/*" multiple>
                                        </div>
                                        <button type="submit" class="admin-icon-btn admin-icon-btn--sky admin-icon-btn-block" title="Lưu">
                                            @include('admin.partials.icon', ['name' => 'save', 'class' => 'w-5 h-5'])
                                        </button>
                                    </form>
                                </div>
                            </details>
                            <form method="POST" action="/quan_ly_bien_the/xoa/{{ $bt->id }}" onsubmit="return confirm('Xóa biến thể này?')" class="inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa biến thể">
                                    @include('admin.partials.icon', ['name' => 'trash', 'class' => 'w-5 h-5'])
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('formBienTheThem', () => ({
        productId: '',
        loai: [],
        dangTai: false,
        async taiLoaiBienThe() {
            this.loai = [];
            if (!this.productId) return;
            this.dangTai = true;
            try {
                const r = await fetch('/quan_ly_bien_the/loai_theo_san_pham/' + this.productId, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const j = await r.json();
                this.loai = j.loai_bien_the || [];
            } catch (e) {
                this.loai = [];
            } finally {
                this.dangTai = false;
            }
        }
    }));
});
</script>
@endpush

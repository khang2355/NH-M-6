@extends('admin.layouts.app')
@section('title', 'Quản lý danh mục')
@section('breadcrumb', 'Danh mục')
@section('page_title', 'Quản lý danh mục')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-6xl mx-auto space-y-8 admin-fade-up">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/50">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Thêm danh mục</h2>
        <form method="POST" action="/quan_ly_danh_muc/them" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Tên</label>
                    <input type="text" name="ten" class="{{ $inp }}" placeholder="Tên danh mục" required value="{{ old('ten') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Ảnh đại diện</label>
                    <input type="file" name="hinh_anh" accept="image/*" class="{{ $inp }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Mô tả</label>
                    <textarea name="mo_ta" rows="2" class="{{ $inp }}" placeholder="Mô tả ngắn">{{ old('mo_ta') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Loại biến thể áp dụng</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($loaiBienThes as $loai)
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 cursor-pointer hover:border-sky-400 hover:bg-sky-50/60 transition shadow-sm">
                            <input type="checkbox" name="variant_types[]" value="{{ $loai->id }}" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            <span class="text-sm font-semibold text-slate-800">{{ $loai->ten }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Chọn một hoặc nhiều loại (Màu sắc, Kích cỡ…).</p>
                </div>
            </div>
            <button type="submit" class="admin-btn-compact">
                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                Thêm
            </button>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-lg shadow-slate-200/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Danh sách</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Mô tả</th>
                        <th class="px-4 py-3">Ảnh</th>
                        <th class="px-4 py-3">Loại biến thể</th>
                        <th class="px-4 py-3 w-48">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($danhmucs as $dm)
                    <tr class="hover:bg-sky-50/40 transition-colors">
                        <td class="px-4 py-3 font-mono text-slate-500">{{ $dm->id }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $dm->ten }}</td>
                        <td class="px-4 py-3 text-slate-600 max-w-xs truncate">{{ $dm->mo_ta }}</td>
                        <td class="px-4 py-3">
                            @if($dm->hinh_anh)
                                <img src="{{ url_anh_public($dm->hinh_anh) }}" alt="" class="w-14 h-14 object-contain rounded-2xl ring-2 ring-white shadow bg-slate-50 hover:scale-105 transition-transform">
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($dm->variantTypes as $vt)
                                    <span class="inline-flex px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800 text-xs font-medium">{{ $vt->ten }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 relative">
                            <div class="flex flex-wrap items-center gap-2 justify-end">
                            <a href="/quan_ly_san_pham?danh_muc={{ $dm->id }}" class="admin-icon-btn admin-icon-btn--slate no-underline" title="Sản phẩm danh mục">
                                @include('admin.partials.icon', ['name' => 'eye', 'class' => 'w-5 h-5'])
                            </a>
                            <details class="group relative">
                                <summary class="admin-icon-btn admin-icon-btn--indigo cursor-pointer list-none" title="Sửa danh mục">
                                    @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                                </summary>
                                <div class="absolute right-0 z-30 mt-2 w-[min(100vw-2rem,24rem)] p-4 rounded-2xl bg-white border border-slate-200 shadow-2xl shadow-indigo-200/30 space-y-3">
                                    <form method="POST" action="/quan_ly_danh_muc/sua/{{ $dm->id }}" enctype="multipart/form-data" class="space-y-3">
                                        @csrf
                                        <input type="text" name="ten" class="{{ $inp }}" value="{{ $dm->ten }}" required>
                                        <textarea name="mo_ta" rows="2" class="{{ $inp }}">{{ $dm->mo_ta }}</textarea>
                                        <input type="file" name="hinh_anh" accept="image/*" class="{{ $inp }}">
                                        <p class="text-xs text-slate-500">Để trống ảnh nếu giữ ảnh cũ.</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($loaiBienThes as $loai)
                                            <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 cursor-pointer hover:border-sky-300 text-xs">
                                                <input type="checkbox" name="variant_types[]" value="{{ $loai->id }}" class="rounded border-slate-300 text-sky-600" @checked($dm->variantTypes->contains('id', $loai->id))>
                                                <span class="font-medium text-slate-800">{{ $loai->ten }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        <button type="submit" class="admin-icon-btn admin-icon-btn--sky admin-icon-btn-block" title="Lưu">
                                            @include('admin.partials.icon', ['name' => 'save', 'class' => 'w-5 h-5'])
                                        </button>
                                    </form>
                                </div>
                            </details>
                            <form method="POST" action="/quan_ly_danh_muc/xoa/{{ $dm->id }}" onsubmit="return confirm('Xóa danh mục này?')" class="inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa danh mục">
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

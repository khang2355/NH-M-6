@extends('admin.layouts.app')
@section('title', 'Quản lý banner')
@section('breadcrumb', 'Banner')
@section('page_title', 'Banner')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-4xl mx-auto space-y-8 admin-fade-up">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Thêm banner</h2>
        <form method="POST" action="/quan_ly_banner/them" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            @csrf
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hình ảnh</label>
                <input type="file" name="hinh_anh" accept="image/*" class="{{ $inp }}" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Vị trí (1–3)</label>
                <select name="vi_tri" class="{{ $inp }}" required>
                    <option value="1">Vị trí 1</option>
                    <option value="2">Vị trí 2</option>
                    <option value="3">Vị trí 3</option>
                </select>
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="admin-btn-compact">
                    @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                    Thêm
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 font-bold">Danh sách</div>
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 font-semibold">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Xem trước</th>
                    <th class="px-4 py-3">Vị trí</th>
                    <th class="px-4 py-3 w-52">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($banners as $bn)
                <tr class="hover:bg-sky-50/40 transition-colors">
                    <td class="px-4 py-3 font-mono text-slate-500">{{ $bn->id }}</td>
                    <td class="px-4 py-3">
                        <img src="{{ url_anh_public($bn->hinh_anh) }}" alt="" class="h-20 w-44 object-contain rounded-2xl ring-2 ring-white shadow bg-slate-50 hover:scale-105 transition-transform">
                    </td>
                    <td class="px-4 py-3 font-bold text-sky-700">{{ $bn->vi_tri }}</td>
                    <td class="px-4 py-3 relative">
                        <div class="flex flex-wrap items-center gap-2 justify-end">
                        <details class="group relative">
                            <summary class="admin-icon-btn admin-icon-btn--indigo cursor-pointer list-none" title="Sửa banner">
                                @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                            </summary>
                            <div class="absolute right-0 z-30 mt-2 w-[min(100vw-2rem,20rem)] p-4 rounded-2xl bg-white border border-slate-200 shadow-2xl shadow-indigo-200/30 space-y-3">
                                <form method="POST" action="/quan_ly_banner/sua/{{ $bn->id }}" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <select name="vi_tri" class="{{ $inp }}" required>
                                        @foreach([1,2,3] as $v)
                                            <option value="{{ $v }}" @selected($bn->vi_tri == $v)>Vị trí {{ $v }}</option>
                                        @endforeach
                                    </select>
                                    <input type="file" name="hinh_anh" accept="image/*" class="{{ $inp }}">
                                    <p class="text-xs text-slate-500">Để trống file nếu giữ ảnh hiện tại.</p>
                                    <button type="submit" class="admin-icon-btn admin-icon-btn--sky admin-icon-btn-block" title="Lưu">
                                        @include('admin.partials.icon', ['name' => 'save', 'class' => 'w-5 h-5'])
                                    </button>
                                </form>
                            </div>
                        </details>
                        <form method="POST" action="/quan_ly_banner/xoa/{{ $bn->id }}" onsubmit="return confirm('Xóa banner?')" class="inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa banner">
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
@endsection

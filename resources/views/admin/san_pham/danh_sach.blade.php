@extends('admin.layouts.app')
@section('title', 'Quản lý sản phẩm')
@section('breadcrumb', 'Sản phẩm')
@section('page_title', 'Sản phẩm')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-6xl mx-auto space-y-6 admin-fade-up">
    <div class="admin-table-card p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Sản phẩm</h2>
            <a href="/quan_ly_san_pham/them" class="admin-btn-compact no-underline">
                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                Thêm
            </a>
        </div>

        <form method="GET" action="/quan_ly_san_pham" class="admin-search-panel admin-search-row mt-5">
            <div class="admin-input-wrap">
                <span class="admin-input-icon" aria-hidden="true">@include('admin.partials.icon', ['name' => 'search', 'class' => 'w-5 h-5'])</span>
                <label class="admin-sr-only" for="q-sp">Tìm theo tên</label>
                <input id="q-sp" type="search" name="q" value="{{ request('q') }}" placeholder="Tên sản phẩm…" class="{{ $inp }}">
            </div>
            <div>
                <label class="admin-sr-only" for="dm-sp">Danh mục</label>
                <select id="dm-sp" name="danh_muc" class="{{ $inp }}" title="Danh mục">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected((string) request('danh_muc') === (string) $cat->id)>{{ $cat->ten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-search-actions">
                <button type="submit" class="admin-icon-btn admin-icon-btn--sky" title="Lọc">
                    @include('admin.partials.icon', ['name' => 'filter', 'class' => 'w-5 h-5'])
                </button>
                @if(request()->hasAny(['q', 'danh_muc']))
                <a href="/quan_ly_san_pham" class="admin-icon-btn admin-icon-btn--slate no-underline" title="Xóa bộ lọc">
                    @include('admin.partials.icon', ['name' => 'x-mark', 'class' => 'w-5 h-5'])
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($products as $sp)
        <div class="admin-product-card">
            <div class="p-4 sm:p-5 flex flex-col lg:flex-row gap-4 lg:gap-6 lg:items-center">
                <div class="flex-1 min-w-0 grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-3 text-sm">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 tabular-nums">#{{ $sp->id }}</p>
                        <p class="font-bold text-slate-900 leading-snug line-clamp-2 mt-0.5">{{ $sp->ten }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400">Danh mục</p>
                        <p class="font-medium text-slate-700">{{ $sp->category->ten ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400">Giá · Biến thể</p>
                        <p class="tabular-nums font-semibold text-sky-800">{{ number_format($sp->gia_ban) }}đ <span class="text-slate-400 font-normal">·</span> <span class="text-indigo-600">{{ $sp->variants->count() }}</span></p>
                    </div>
                </div>
                <div class="admin-product-toolbar lg:shrink-0">
                    <a href="/quan_ly_san_pham/sua/{{ $sp->id }}" class="admin-icon-btn admin-icon-btn--indigo no-underline" title="Sửa sản phẩm">
                        @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                    </a>
                    <form method="POST" action="/quan_ly_san_pham/xoa/{{ $sp->id }}" class="inline m-0" onsubmit="return confirm('Xóa sản phẩm và toàn bộ biến thể?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa sản phẩm">
                            @include('admin.partials.icon', ['name' => 'trash', 'class' => 'w-5 h-5'])
                        </button>
                    </form>
                </div>
            </div>
            <details class="border-t border-slate-100 group">
                <summary class="cursor-pointer list-none px-4 sm:px-5 py-3 text-sm font-semibold text-indigo-700 bg-slate-50/90 hover:bg-indigo-50/80 transition flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-2">
                        @include('admin.partials.icon', ['name' => 'eye', 'class' => 'w-4 h-4 opacity-80'])
                        Biến thể ({{ $sp->variants->count() }})
                    </span>
                    <span class="inline-flex text-indigo-400 transition-transform duration-300 group-open:rotate-180">@include('admin.partials.icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])</span>
                </summary>
                <div class="p-4 sm:p-5 bg-white">
                    @if($sp->variants->isEmpty())
                        <p class="text-sm text-slate-500">Chưa có biến thể. <a href="/quan_ly_san_pham/sua/{{ $sp->id }}" class="font-semibold text-indigo-600 hover:underline">Thêm tại trang sửa</a></p>
                    @else
                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-xs text-left min-w-[480px]">
                            <thead class="bg-slate-100 text-slate-600 font-semibold">
                                <tr>
                                    <th class="px-3 py-2">#</th>
                                    <th class="px-3 py-2">Thuộc tính</th>
                                    <th class="px-3 py-2">Giá riêng</th>
                                    <th class="px-3 py-2">Ảnh</th>
                                    <th class="px-3 py-2">Tồn</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($sp->variants as $bt)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-3 py-2 font-mono text-slate-500">{{ $bt->id }}</td>
                                    <td class="px-3 py-2">
                                        @foreach($bt->gia_tri_bien_the as $k => $v)
                                            <span class="inline-flex mr-1 mb-1 px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800">{{ $k }}: {{ $v }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-3 py-2 tabular-nums">
                                        @if($bt->gia_ban !== null && $bt->gia_ban !== '')
                                            {{ number_format($bt->gia_ban) }}đ
                                        @else
                                            <span class="text-slate-400">SP</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($bt->images as $img)
                                                <img src="{{ url_anh_public($img->hinh_anh) }}" class="w-9 h-9 object-cover rounded-lg ring-1 ring-slate-200" alt="">
                                            @empty
                                                <span class="text-slate-400">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 font-semibold">{{ $bt->so_luong }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </details>
        </div>
        @empty
        <div class="rounded-2xl border border-dashed border-slate-200 bg-white py-16 text-center text-slate-500">
            Không có sản phẩm. <a href="/quan_ly_san_pham/them" class="text-indigo-600 font-semibold hover:underline">Tạo mới</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

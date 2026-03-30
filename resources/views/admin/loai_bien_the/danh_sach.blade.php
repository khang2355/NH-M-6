@extends('admin.layouts.app')
@section('title', 'Loại biến thể')
@section('breadcrumb', 'Loại biến thể')
@section('page_title', 'Quản lý loại biến thể')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-3xl mx-auto space-y-8 admin-fade-up">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Thêm loại biến thể</h2>
        <form method="POST" action="/quan_ly_loai_bien_the/them" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="text" name="ten" class="{{ $inp }} flex-1" placeholder="Ví dụ: Màu sắc, Kích cỡ" required value="{{ old('ten') }}">
            <button type="submit" class="admin-btn-compact shrink-0">
                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
                Thêm
            </button>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 font-bold text-slate-900">Danh sách</div>
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 font-semibold">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Tên</th>
                    <th class="px-4 py-3 w-56">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($loaiBienThes as $loai)
                <tr class="hover:bg-sky-50/40 transition-colors">
                    <td class="px-4 py-3 font-mono text-slate-500">{{ $loai->id }}</td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $loai->ten }}</td>
                    <td class="px-4 py-3 relative">
                        <div class="flex flex-wrap items-center gap-2 justify-end">
                        <details class="group relative">
                            <summary class="admin-icon-btn admin-icon-btn--indigo cursor-pointer list-none" title="Sửa">
                                @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                            </summary>
                            <div class="absolute right-0 z-30 mt-2 w-[min(100vw-2rem,18rem)] p-3 rounded-2xl bg-white border border-slate-200 shadow-2xl shadow-indigo-200/30">
                                <form method="POST" action="/quan_ly_loai_bien_the/sua/{{ $loai->id }}" class="flex gap-2 items-center">
                                    @csrf
                                    <input type="text" name="ten" class="{{ $inp }}" value="{{ $loai->ten }}" required>
                                    <button type="submit" class="admin-icon-btn admin-icon-btn--sky shrink-0" title="Lưu">
                                        @include('admin.partials.icon', ['name' => 'save', 'class' => 'w-5 h-5'])
                                    </button>
                                </form>
                            </div>
                        </details>
                        <form method="POST" action="/quan_ly_loai_bien_the/xoa/{{ $loai->id }}" onsubmit="return confirm('Xóa loại biến thể?')" class="inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa">
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

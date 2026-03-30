@extends('admin.layouts.app')
@section('title', 'Dashboard — Quản trị')
@section('breadcrumb', 'Tổng quan')
@section('page_title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 admin-fade-up">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Xin chào, {{ Auth::user()->name }}</h1>
            <p class="mt-1 text-slate-500 text-sm">Tổng quan nhanh.</p>
        </div>
        <a href="/" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white border border-slate-200/80 text-slate-700 font-medium shadow-sm hover:shadow-md hover:border-indigo-300 hover:text-indigo-600 transition-all duration-300 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Xem cửa hàng
        </a>
        
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        @php
            $cards = [
                ['key' => 'san_pham', 'label' => 'Sản phẩm', 'href' => '/quan_ly_san_pham', 'icon' => 'box', 'from' => 'from-violet-500', 'to' => 'to-fuchsia-600'],
                ['key' => 'danh_muc', 'label' => 'Danh mục', 'href' => '/quan_ly_danh_muc', 'icon' => 'folder', 'from' => 'from-sky-500', 'to' => 'to-cyan-600'],
                ['key' => 'bien_the', 'label' => 'Biến thể (trong SP)', 'href' => '/quan_ly_san_pham', 'icon' => 'layers', 'from' => 'from-emerald-500', 'to' => 'to-teal-600'],
                ['key' => 'banner', 'label' => 'Banner', 'href' => '/quan_ly_banner', 'icon' => 'image', 'from' => 'from-amber-500', 'to' => 'to-orange-600'],
                ['key' => 'tai_khoan', 'label' => 'Tài khoản', 'href' => '/quan_ly_tai_khoan', 'icon' => 'users', 'from' => 'from-rose-500', 'to' => 'to-pink-600'],
                ['key' => 'lien_he', 'label' => 'Liên hệ (tin)', 'href' => '#', 'icon' => 'mail', 'from' => 'from-indigo-500', 'to' => 'to-blue-600'],
            ];
        @endphp
        @foreach($cards as $i => $c)
        <a href="{{ $c['href'] }}" class="group relative overflow-hidden rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:border-transparent hover:shadow-xl hover:shadow-indigo-100/80 transition-all duration-500 hover:-translate-y-1.5 admin-stagger"
           style="animation-delay: {{ $i * 60 }}ms">
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br {{ $c['from'] }} {{ $c['to'] }} opacity-10 blur-2xl group-hover:opacity-25 group-hover:scale-150 transition-all duration-700"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 group-hover:text-slate-600 transition-colors">{{ $c['label'] }}</p>
                    <p class="mt-2 text-4xl font-bold tabular-nums bg-gradient-to-r {{ $c['from'] }} {{ $c['to'] }} bg-clip-text text-transparent">{{ number_format($stats[$c['key']]) }}</p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br {{ $c['from'] }} {{ $c['to'] }} text-white shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-400">
                    @if($c['icon'] === 'box')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @elseif($c['icon'] === 'folder')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    @elseif($c['icon'] === 'layers')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7l8-4 8 4M4 12l8 4 8-4M4 17l8 4 8-4"/></svg>
                    @elseif($c['icon'] === 'image')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @elseif($c['icon'] === 'users')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @endif
                </div>
            </div>
            <div class="mt-4 flex items-center justify-end text-indigo-600 opacity-0 group-hover:opacity-100 transition-all duration-300">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 group-hover:bg-indigo-100 group-hover:translate-x-1 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </span>
            </div>
        </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/40 p-6 hover:shadow-2xl transition-shadow duration-500">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-slate-900">Sản phẩm mới nhất</h2>
                <a href="/quan_ly_san_pham" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors" title="Tất cả sản phẩm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-500">
                            <th class="pb-3 font-medium">Tên</th>
                            <th class="pb-3 font-medium">Danh mục</th>
                            <th class="pb-3 font-medium text-right">Giá bán</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($san_pham_moi as $sp)
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 font-medium text-slate-800">{{ $sp->ten }}</td>
                            <td class="py-3 text-slate-600">{{ $sp->category->ten ?? '—' }}</td>
                            <td class="py-3 text-right tabular-nums text-slate-900">{{ number_format($sp->gia_ban) }}đ</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="py-8 text-center text-slate-400">Chưa có sản phẩm.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-3xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-600 p-6 text-white shadow-xl shadow-indigo-300/40 hover:scale-[1.02] transition-transform duration-500">
                <h3 class="font-bold text-lg mb-3">Lối tắt</h3>
                <div class="space-y-2">
                    <a href="/quan_ly_loai_bien_the" class="flex items-center gap-3 rounded-2xl bg-white/15 hover:bg-white/25 px-4 py-3 text-sm font-medium backdrop-blur transition-all duration-300 hover:translate-x-1">
                        @include('admin.partials.icon', ['name' => 'filter', 'class' => 'w-5 h-5 opacity-90'])
                        Loại biến thể
                    </a>
                    <a href="/quan_ly_san_pham/them" class="flex items-center gap-3 rounded-2xl bg-white/15 hover:bg-white/25 px-4 py-3 text-sm font-medium backdrop-blur transition-all duration-300 hover:translate-x-1">
                        @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5 opacity-90'])
                        Sản phẩm mới
                    </a>
                    <a href="/quan_ly_banner" class="flex items-center gap-3 rounded-2xl bg-white/15 hover:bg-white/25 px-4 py-3 text-sm font-medium backdrop-blur transition-all duration-300 hover:translate-x-1">
                        @include('admin.partials.icon', ['name' => 'image', 'class' => 'w-5 h-5 opacity-90'])
                        Banner
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $path = request()->path();
@endphp
<aside class="w-72 shrink-0 admin-sidebar-gradient text-slate-200 flex flex-col min-h-screen shadow-2xl shadow-indigo-950/50 border-r border-white/5">
    <div class="p-6 pb-4">
        <a href="/quan_ly" class="group flex items-center gap-3 rounded-2xl p-2 -m-2 transition hover:bg-white/5">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-400 to-violet-600 text-white shadow-lg shadow-indigo-500/30 group-hover:scale-105 group-hover:rotate-3 transition duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </span>
            <div>
                <div class="text-lg font-bold tracking-tight text-white">E-Shop</div>
                <div class="text-xs text-indigo-200/80">Bảng quản trị</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
        <a href="/quan_ly" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Dashboard
        </a>
        <div class="pt-4 pb-1 px-4 text-[10px] font-bold uppercase tracking-widest text-indigo-300/60">Quản lý dữ liệu</div>
        <a href="/quan_ly_tai_khoan" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly_tai_khoan' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Tài khoản
        </a>
        <a href="/quan_ly_danh_muc" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly_danh_muc' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            Danh mục
        </a>
        <a href="/quan_ly_loai_bien_the" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly_loai_bien_the' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
            Loại biến thể
        </a>
        <a href="/quan_ly_san_pham" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly_san_pham' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Sản phẩm
        </a>
        <a href="/quan_ly_banner" class="admin-nav-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ $path === 'quan_ly_banner' ? 'active text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Banner
        </a>
    </nav>

    <div class="p-4 mt-auto border-t border-white/10">
        <form action="/dang_xuat" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-2xl bg-white/5 hover:bg-rose-500/20 hover:text-rose-200 text-slate-300 py-3 text-sm font-semibold transition-all duration-300 hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Đăng xuất
            </button>
        </form>
    </div>
</aside>

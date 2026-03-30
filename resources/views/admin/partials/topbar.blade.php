<header class="admin-glass sticky top-0 z-30 border-b border-slate-200/80 px-4 sm:px-8 py-4 flex items-center justify-between gap-4 shadow-sm shadow-slate-200/50">
    <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">@yield('breadcrumb', 'Quản trị')</p>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">@yield('page_title', 'Bảng điều khiển')</h1>
    </div>
    <div class="flex items-center gap-3 sm:gap-5">
        <a href="/" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center justify-center w-11 h-11 rounded-2xl text-slate-600 bg-white border border-slate-200 hover:border-indigo-400 hover:text-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300" title="Mở cửa hàng">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
        </a>
        <div class="flex items-center gap-3 pl-3 sm:pl-5 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <div class="text-sm font-bold text-slate-900">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-xs text-slate-500">{{ Auth::user()->role === 'admin' ? 'Quản trị viên' : 'Người dùng' }}</div>
            </div>
            <div class="relative group">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode(Auth::user()->email ?? 'admin') }}" alt="" class="w-11 h-11 rounded-2xl border-2 border-white shadow-md ring-2 ring-indigo-100 group-hover:ring-indigo-300 group-hover:scale-105 transition-all duration-300 cursor-pointer">
                <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white"></span>
            </div>
        </div>
    </div>
</header>

@php
    $categories = $categories ?? \App\Models\Category::orderBy('ten')->get();
@endphp
<header class="sticky top-0 z-50" x-data="{ mobile: false }">
    <div class="absolute inset-0 bg-white/75 backdrop-blur-xl border-b border-slate-200/60 shadow-sm shadow-slate-200/40"></div>
    <nav class="relative container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[4.25rem]">
            <a href="/" class="group flex items-center gap-2.5 rounded-2xl py-1 pr-3 -ml-2 transition hover:bg-white/60">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 via-violet-500 to-fuchsia-500 text-white shadow-lg shadow-indigo-400/30 group-hover:scale-105 group-hover:rotate-6 transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </span>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-fuchsia-600 bg-clip-text text-transparent">E-Shop</span>
            </a>

            <div class="hidden lg:flex items-center gap-1">
                <a href="/" class="px-4 py-2 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300">Trang chủ</a>
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 px-4 py-2 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300">
                        Danh mục
                        <svg class="w-4 h-4 opacity-60 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-1 group-hover:translate-y-0">
                        <div class="min-w-[220px] rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200/80 shadow-xl shadow-indigo-100/50 py-2 overflow-hidden">
                            @foreach($categories as $cat)
                            <a href="/danh_muc/{{ $cat->id }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-violet-50 hover:text-indigo-700 transition-colors">
                                {{ $cat->ten }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <a href="{{ route('gioi_thieu') }}" class="px-4 py-2 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300">Giới thiệu</a>
                <a href="/lien_he" class="px-4 py-2 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300">Liên hệ</a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                @if(Auth::user()->role === 'admin')
                <a href="/quan_ly" class="hidden sm:inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 hover:scale-105 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Quản trị
                </a>
                @endif
                <a href="/gio_hang" class="relative inline-flex items-center justify-center h-11 w-11 sm:w-auto sm:px-5 rounded-2xl font-semibold text-sm text-white store-btn-primary store-shine group">
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="hidden sm:inline">Giỏ hàng</span>
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-fuchsia-500 text-[10px] font-bold text-white shadow-md animate-pulse">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    @endif
                </a>
                @else
                <a href="/dang_nhap" class="relative inline-flex items-center justify-center h-11 w-11 sm:w-auto sm:px-5 rounded-2xl font-semibold text-sm border-2 border-slate-200 text-slate-700 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300" title="Đăng nhập để dùng giỏ hàng">
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="hidden sm:inline">Giỏ hàng</span>
                </a>
                @endauth

                @auth
                <div class="hidden sm:flex items-center gap-2 pl-2 border-l border-slate-200/80">
                    <span class="text-sm font-medium text-slate-600 max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                    <form action="/dang_xuat" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-700 px-3 py-2 rounded-2xl hover:bg-rose-50 transition">Đăng xuất</button>
                    </form>
                </div>
                @else
                <div class="hidden sm:flex items-center gap-2">
                    <a href="/dang_nhap" class="text-sm font-semibold text-slate-700 px-4 py-2 rounded-2xl hover:bg-white/90 border border-transparent hover:border-slate-200 transition">Đăng nhập</a>
                    <a href="/dang_ky" class="text-sm font-semibold text-white px-4 py-2 rounded-2xl store-btn-primary">Đăng ký</a>
                </div>
                @endauth

                <button type="button" @click="mobile = !mobile" class="lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white/80 text-slate-700 hover:bg-indigo-50 transition">
                    <svg x-show="!mobile" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobile" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="mobile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="lg:hidden border-t border-slate-200/60 py-4 space-y-1">
            <a href="/" class="block px-4 py-3 rounded-2xl font-semibold text-slate-800 hover:bg-indigo-50">Trang chủ</a>
            @foreach($categories as $cat)
            <a href="/danh_muc/{{ $cat->id }}" class="block px-4 py-3 rounded-2xl font-medium text-slate-700 hover:bg-indigo-50">{{ $cat->ten }}</a>
            @endforeach
            <a href="{{ route('gioi_thieu') }}" class="block px-4 py-3 rounded-2xl font-semibold text-slate-800 hover:bg-indigo-50">Giới thiệu</a>
            <a href="/lien_he" class="block px-4 py-3 rounded-2xl font-semibold text-slate-800 hover:bg-indigo-50">Liên hệ</a>
            @auth
                @if(Auth::user()->role === 'admin')
                <a href="/quan_ly" class="block px-4 py-3 rounded-2xl font-bold text-indigo-700 bg-indigo-50">Quản trị</a>
                @endif
            @endauth
            @guest
            <div class="pt-2 flex gap-2 px-4">
                <a href="/dang_nhap" class="flex-1 text-center py-3 rounded-2xl font-semibold border border-slate-200">Đăng nhập</a>
                <a href="/dang_ky" class="flex-1 text-center py-3 rounded-2xl font-semibold text-white store-btn-primary">Đăng ký</a>
            </div>
            @endguest
        </div>
    </nav>
</header>

<footer class="mt-auto relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-fuchsia-500/15 blur-3xl pointer-events-none"></div>
    <div class="relative container mx-auto px-4 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </span>
                    <span class="text-xl font-bold text-white">E-Shop</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Mua sắm hiện đại — giao diện tối ưu, trải nghiệm mượt với hiệu ứng và hover tinh tế.</p>
            </div>
            <div>
                <h3 class="text-white font-bold mb-4">Khám phá</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-slate-400 hover:text-white text-sm font-medium transition-colors duration-300 inline-block hover:translate-x-1 transform">Trang chủ</a></li>
                    <li><a href="/lien_he" class="text-slate-400 hover:text-white text-sm font-medium transition-colors duration-300 inline-block hover:translate-x-1 transform">Liên hệ</a></li>
                    @auth
                    <li><a href="/gio_hang" class="text-slate-400 hover:text-white text-sm font-medium transition-colors duration-300 inline-block hover:translate-x-1 transform">Giỏ hàng</a></li>
                    @else
                    <li><a href="/dang_nhap" class="text-slate-400 hover:text-white text-sm font-medium transition-colors duration-300 inline-block hover:translate-x-1 transform">Đăng nhập</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="text-white font-bold mb-4">Danh mục</h3>
                <ul class="space-y-2">
                    @foreach(($categories ?? \App\Models\Category::orderBy('ten')->take(5)->get()) as $fc)
                    <li><a href="/danh_muc/{{ $fc->id }}" class="text-slate-400 hover:text-white text-sm font-medium transition-colors duration-300 inline-block hover:translate-x-1 transform">{{ $fc->ten }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-12 pt-8 border-t border-white/10 text-center text-slate-500 text-sm">
            &copy; {{ date('Y') }} E-Shop. Thiết kế UI/UX hiện đại.
        </div>
    </div>
</footer>

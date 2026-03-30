@extends('layouts.app')
@section('title', 'Liên hệ — E-Shop')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-14 max-w-6xl">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">
        <div class="lg:pt-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">Liên hệ với chúng tôi</h1>
            <p class="mt-4 text-slate-600 leading-relaxed">Điền form bên cạnh — chúng tôi phản hồi trong thời gian sớm nhất có thể.</p>
            <div class="mt-10 space-y-6">
                <div class="flex gap-4 p-4 rounded-2xl bg-white/80 border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <div>
                        <p class="font-bold text-slate-900">Email</p>
                        <p class="text-slate-500 text-sm">support@eshop.local</p>
                    </div>
                </div>
                <div class="flex gap-4 p-4 rounded-2xl bg-white/80 border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-fuchsia-100 text-fuchsia-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </span>
                    <div>
                        <p class="font-bold text-slate-900">Hotline</p>
                        <p class="text-slate-500 text-sm">1900 xxxx (giờ hành chính)</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] bg-white/90 backdrop-blur border border-slate-100 p-6 sm:p-8 shadow-2xl shadow-indigo-100/40 hover:shadow-indigo-200/50 transition-shadow duration-500">
            <form method="POST" action="/lien_he" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Tên</label>
                    <input name="ten" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Email</label>
                    <input name="email" type="email" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Số điện thoại</label>
                    <input name="so_dien_thoai" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Nội dung</label>
                    <textarea name="noi_dung" rows="4" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm resize-none" required></textarea>
                </div>
                <button type="submit" class="w-full py-4 rounded-2xl text-white font-bold store-btn-primary store-shine">
                    Gửi liên hệ
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

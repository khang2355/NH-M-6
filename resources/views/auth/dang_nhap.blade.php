@extends('layouts.app')
@section('title', 'Đăng nhập — E-Shop')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="rounded-[2rem] bg-white/90 backdrop-blur border border-slate-100 p-8 sm:p-10 shadow-2xl shadow-indigo-100/50 hover:shadow-indigo-200/40 transition-shadow duration-500">
            <div class="text-center mb-8">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-fuchsia-600 text-white shadow-lg mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Đăng nhập</h2>
                <p class="mt-2 text-sm text-slate-500">Chào mừng bạn quay lại E-Shop</p>
            </div>
            <form method="POST" action="/dang_nhap" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required autofocus>
                </div>
                @error('email')
                    <p class="text-sm text-rose-600 font-medium">{{ $message }}</p>
                @enderror
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Mật khẩu</label>
                    <input type="password" name="password" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required>
                </div>
                <button type="submit" class="w-full py-4 rounded-2xl text-white font-bold store-btn-primary store-shine">
                    Đăng nhập
                </button>
            </form>
            <p class="mt-8 text-center text-sm text-slate-600">
                Chưa có tài khoản?
                <a href="/dang_ky" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>
@endsection

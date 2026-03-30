@extends('layouts.app')
@section('title', 'Đăng ký — E-Shop')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="rounded-[2rem] bg-white/90 backdrop-blur border border-slate-100 p-8 sm:p-10 shadow-2xl shadow-fuchsia-100/50 hover:shadow-fuchsia-200/40 transition-shadow duration-500">
            <div class="text-center mb-8">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500 to-indigo-600 text-white shadow-lg mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-3-3a9 9 0 11-18 0 9 9 0 0118 0zm-9-9v12"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Tạo tài khoản</h2>
                <p class="mt-2 text-sm text-slate-500">Tham gia E-Shop để mua sắm và quản lý giỏ hàng</p>
            </div>
            <form method="POST" action="/dang_ky" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Tên</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Mật khẩu</label>
                    <input type="password" name="password" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:ring-2 focus:ring-indigo-400 transition shadow-sm" required>
                </div>
                @if ($errors->any())
                    <div class="rounded-2xl bg-rose-50 border border-rose-100 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif
                <button type="submit" class="w-full py-4 rounded-2xl text-white font-bold store-btn-primary store-shine mt-2">
                    Đăng ký
                </button>
            </form>
            <p class="mt-8 text-center text-sm text-slate-600">
                Đã có tài khoản?
                <a href="/dang_nhap" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Thêm tài khoản')
@section('breadcrumb', 'Tài khoản')
@section('page_title', 'Thêm tài khoản mới')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-xl mx-auto space-y-6 admin-fade-up">
    <a href="/quan_ly_tai_khoan" class="admin-btn-ghost text-sm inline-flex">← Danh sách tài khoản</a>

    <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-lg">
        <h2 class="text-lg font-bold text-slate-900 mb-2">Tạo tài khoản</h2>
        <p class="text-sm text-slate-500 mb-6">Chọn vai trò phù hợp. Chỉ <strong>Quản trị viên</strong> mới vào được khu vực quản lý.</p>

        <div class="rounded-2xl border border-sky-100 bg-sky-50/50 p-4 mb-6 text-sm text-slate-700 space-y-2">
            <p class="font-bold text-sky-900">Phân quyền</p>
            <ul class="list-disc pl-5 space-y-1 text-slate-600">
                <li><span class="font-semibold text-violet-800">admin</span> — Truy cập /quan_ly, quản lý sản phẩm, danh mục, banner, tài khoản…</li>
                <li><span class="font-semibold text-slate-800">user</span> — Khách hàng: mua hàng, giỏ hàng, không vào admin.</li>
            </ul>
        </div>

        <form method="POST" action="/quan_ly_tai_khoan/them" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Họ tên</label>
                <input type="text" name="name" class="{{ $inp }}" required value="{{ old('name') }}">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                <input type="email" name="email" class="{{ $inp }}" required value="{{ old('email') }}">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mật khẩu</label>
                <input type="password" name="password" class="{{ $inp }}" required minlength="6">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Vai trò</label>
                <select name="role" class="{{ $inp }}" required>
                    <option value="user" @selected(old('role') === 'user')>user — Khách hàng</option>
                    <option value="admin" @selected(old('role') === 'admin')>admin — Quản trị viên</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="admin-btn-primary">Tạo tài khoản</button>
                <a href="/quan_ly_tai_khoan" class="admin-btn-ghost">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Quản lý tài khoản')
@section('breadcrumb', 'Tài khoản')
@section('page_title', 'Tài khoản')

@section('content')
@php
    $inp = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition outline-none';
@endphp
<div class="max-w-5xl mx-auto space-y-6 admin-fade-up">
    <p class="text-xs text-slate-500 leading-relaxed max-w-3xl">
        <strong class="text-slate-700">admin</strong> — quản trị · <strong class="text-slate-700">user</strong> — chỉ cửa hàng (không /quan_ly).
    </p>

    <div class="flex flex-wrap justify-between items-center gap-3">
        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Danh sách</h2>
        <a href="/quan_ly_tai_khoan/them" class="admin-btn-compact no-underline">
            @include('admin.partials.icon', ['name' => 'plus', 'class' => 'w-5 h-5'])
            Thêm
        </a>
    </div>

    <div class="admin-table-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Vai trò</th>
                        <th class="px-4 py-3 text-right w-36">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-indigo-50/20 transition-colors">
                        <td class="px-4 py-3 font-mono text-slate-500 tabular-nums">{{ $user->id }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold {{ $user->role === 'admin' ? 'bg-violet-100 text-violet-800' : 'bg-slate-100 text-slate-700' }}">{{ $user->role }}</span>
                        </td>
                        <td class="px-4 py-3 relative">
                            <div class="flex flex-wrap items-center justify-end gap-2">
                                <details class="group relative">
                                    <summary class="admin-icon-btn admin-icon-btn--indigo cursor-pointer list-none" title="Sửa">
                                        @include('admin.partials.icon', ['name' => 'pencil', 'class' => 'w-5 h-5'])
                                    </summary>
                                    <div class="absolute right-0 z-20 mt-2 w-[min(100vw-2rem,22rem)] p-4 rounded-2xl bg-white border border-slate-200 shadow-2xl shadow-indigo-200/40 space-y-3 animate-[adminFadeUp_0.25s_ease-out]">
                                        <form method="POST" action="/quan_ly_tai_khoan/sua/{{ $user->id }}" class="space-y-3">
                                            @csrf
                                            <input type="text" name="name" class="{{ $inp }}" value="{{ $user->name }}" required aria-label="Tên">
                                            <input type="email" name="email" class="{{ $inp }}" value="{{ $user->email }}" required aria-label="Email">
                                            <input type="password" name="password" class="{{ $inp }}" placeholder="Mật khẩu mới (trống = giữ)" aria-label="Mật khẩu">
                                            <select name="role" class="{{ $inp }}" required aria-label="Vai trò">
                                                <option value="user" @selected($user->role === 'user')>user</option>
                                                <option value="admin" @selected($user->role === 'admin')>admin</option>
                                            </select>
                                            <button type="submit" class="admin-icon-btn admin-icon-btn--sky admin-icon-btn-block" title="Lưu">
                                                @include('admin.partials.icon', ['name' => 'save', 'class' => 'w-5 h-5'])
                                            </button>
                                        </form>
                                    </div>
                                </details>
                                <form method="POST" action="/quan_ly_tai_khoan/xoa/{{ $user->id }}" class="inline m-0" onsubmit="return confirm('Xóa tài khoản?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-icon-btn admin-icon-btn--rose" title="Xóa" @disabled($user->id === auth()->id())>
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
</div>
@endsection

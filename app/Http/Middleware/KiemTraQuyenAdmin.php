<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KiemTraQuyenAdmin
{
    /**
     * Chỉ cho phép người dùng đã đăng nhập có role admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->guest(route('dang_nhap'));
        }

        if ($request->user()->role !== 'admin') {
            return redirect('/')->withErrors([
                'quyen' => 'Tài khoản của bạn không có quyền quản trị.',
            ]);
        }

        return $next($request);
    }
}

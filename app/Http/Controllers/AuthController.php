<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function hien_thi_dang_nhap()
    {
        return view('auth.dang_nhap');
    }
    public function xu_ly_dang_nhap(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $home = Auth::user()->role === 'admin' ? '/quan_ly' : '/';
            return redirect()->intended($home);
        }
        return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng']);
    }
    public function hien_thi_dang_ky()
    {
        return view('auth.dang_ky');
    }
    public function xu_ly_dang_ky(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);
        Auth::login($user);
        return redirect('/');
    }
    public function dang_xuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/dang_nhap');
    }
}

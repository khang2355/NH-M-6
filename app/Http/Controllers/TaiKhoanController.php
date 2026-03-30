<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TaiKhoanController extends Controller
{
    public function danh_sach_tai_khoan()
    {
        $users = User::orderBy('id')->get();

        return view('admin.tai_khoan.danh_sach', compact('users'));
    }

    public function form_them_tai_khoan()
    {
        return view('admin.tai_khoan.them');
    }

    public function them_tai_khoan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/quan_ly_tai_khoan')->with('success', 'Thêm tài khoản thành công');
    }

    public function sua_tai_khoan(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,user',
        ]);
        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return back()->with('success', 'Cập nhật tài khoản thành công');
    }

    public function xoa_tai_khoan($id)
    {
        if ((int) $id === auth()->id()) {
            return back()->withErrors(['xoa' => 'Không thể xóa chính tài khoản đang đăng nhập.']);
        }
        User::destroy($id);

        return back()->with('success', 'Xóa tài khoản thành công');
    }
}

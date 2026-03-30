<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VariantType;

class LoaiBienTheController extends Controller
{
    public function danh_sach_loai_bien_the()
    {
        $loaiBienThes = VariantType::all();
        return view('admin.loai_bien_the.danh_sach', compact('loaiBienThes'));
    }
    public function them_loai_bien_the(Request $request)
    {
        $request->validate([
            'ten' => 'required',
        ]);
        VariantType::create($request->only('ten'));
        return back()->with('success', 'Thêm loại biến thể thành công');
    }
    public function sua_loai_bien_the(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);
        $loaiBienThe = VariantType::findOrFail($id);
        $loaiBienThe->update($request->only('ten'));
        return back()->with('success', 'Cập nhật thành công');
    }
    public function xoa_loai_bien_the($id)
    {
        VariantType::destroy($id);
        return back()->with('success', 'Xóa thành công');
    }
}

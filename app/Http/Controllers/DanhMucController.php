<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\VariantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DanhMucController extends Controller
{
    public function danh_sach_danh_muc()
    {
        $danhmucs = Category::with('variantTypes')->get();
        $loaiBienThes = VariantType::all();
        return view('admin.danh_muc.danh_sach', compact('danhmucs', 'loaiBienThes'));
    }
    public function them_danh_muc(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'hinh_anh' => 'nullable|image|max:5120',
            'variant_types' => 'nullable|array',
            'variant_types.*' => 'exists:variant_types,id',
        ]);
        $data = $request->only('ten', 'mo_ta');
        if ($request->hasFile('hinh_anh')) {
            $data['hinh_anh'] = $request->file('hinh_anh')->store('categories', 'public');
        }
        $danhmuc = Category::create($data);
        $danhmuc->variantTypes()->sync($request->variant_types);
        return back()->with('success', 'Thêm danh mục thành công');
    }
    public function sua_danh_muc(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'hinh_anh' => 'nullable|image|max:5120',
            'variant_types' => 'nullable|array',
            'variant_types.*' => 'exists:variant_types,id',
        ]);
        $danhmuc = Category::findOrFail($id);
        $data = $request->only('ten', 'mo_ta');
        if ($request->hasFile('hinh_anh')) {
            if ($danhmuc->hinh_anh) {
                Storage::disk('public')->delete($danhmuc->hinh_anh);
            }
            $data['hinh_anh'] = $request->file('hinh_anh')->store('categories', 'public');
        }
        $danhmuc->update($data);
        $danhmuc->variantTypes()->sync($request->input('variant_types', []));
        return back()->with('success', 'Cập nhật thành công');
    }
    public function xoa_danh_muc($id)
    {
        Category::destroy($id);
        return back()->with('success', 'Xóa thành công');
    }
}

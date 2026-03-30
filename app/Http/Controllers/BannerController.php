<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function danh_sach_banner()
    {
        $banners = Banner::orderBy('vi_tri')->get();
        return view('admin.banner.danh_sach', compact('banners'));
    }
    public function them_banner(Request $request)
    {
        $request->validate([
            'hinh_anh' => 'required|image',
            'vi_tri' => 'required|integer|in:1,2,3',
        ]);
        $data = [
            'vi_tri' => $request->vi_tri,
            'hinh_anh' => $request->file('hinh_anh')->store('banners', 'public'),
        ];
        Banner::create($data);
        return back()->with('success', 'Thêm banner thành công');
    }
    public function sua_banner(Request $request, $id)
    {
        $request->validate([
            'vi_tri' => 'required|integer|in:1,2,3',
            'hinh_anh' => 'nullable|image|max:5120',
        ]);
        $banner = Banner::findOrFail($id);
        $data = ['vi_tri' => $request->vi_tri];
        if ($request->hasFile('hinh_anh')) {
            if ($banner->hinh_anh) {
                Storage::disk('public')->delete($banner->hinh_anh);
            }
            $data['hinh_anh'] = $request->file('hinh_anh')->store('banners', 'public');
        }
        $banner->update($data);
        return back()->with('success', 'Cập nhật thành công');
    }
    public function xoa_banner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            if ($banner->hinh_anh) {
                Storage::disk('public')->delete($banner->hinh_anh);
            }
            $banner->delete();
        }

        return back()->with('success', 'Xóa thành công');
    }
}

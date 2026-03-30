<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\GiaSanPhamValidator;
use App\Models\ProductVariantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BienTheSanPhamController extends Controller
{
    public function danh_sach_bien_the()
    {
        $bienThes = ProductVariant::with(['product.category', 'images'])->orderBy('id', 'desc')->get();
        $sanPhams = Product::with('category')->orderBy('ten')->get();

        return view('admin.bien_the.danh_sach', compact('bienThes', 'sanPhams'));
    }

    public function lay_loai_bien_the_theo_san_pham($product_id)
    {
        $sanPham = Product::with('category.variantTypes')->findOrFail($product_id);
        $loai = $sanPham->category?->variantTypes ?? collect();

        return response()->json([
            'loai_bien_the' => $loai->map(fn ($t) => [
                'id' => $t->id,
                'ten' => $t->ten,
            ])->values(),
        ]);
    }

    public function lay_loai_bien_the_theo_danh_muc($category_id)
    {
        $danhMuc = Category::with('variantTypes')->findOrFail($category_id);
        $loai = $danhMuc->variantTypes;

        return response()->json([
            'loai_bien_the' => $loai->map(fn ($t) => [
                'id' => $t->id,
                'ten' => $t->ten,
            ])->values(),
        ]);
    }

    public function them_bien_the(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'gia_tri_bien_the' => 'required|array',
            'so_luong' => 'required|integer|min:0',
            'gia_ban' => 'nullable|numeric|min:0',
            'gia_sale' => 'nullable|numeric|min:0',
            'hinh_anh' => 'nullable|array',
            'hinh_anh.*' => 'image|max:5120',
        ]);
        $sanPham = Product::findOrFail($request->product_id);
        $giaBanBt = $this->gia_so_hoac_null($request, 'gia_ban');
        $giaSaleBt = $this->gia_so_hoac_null($request, 'gia_sale');
        $loi = GiaSanPhamValidator::loiGiaBienThe($sanPham, $giaBanBt, $giaSaleBt);
        if ($loi) {
            return back()->withErrors(['gia_bien_the' => $loi])->withInput();
        }
        $bienThe = ProductVariant::create([
            'product_id' => $request->product_id,
            'gia_tri_bien_the' => json_encode($request->gia_tri_bien_the),
            'so_luong' => $request->so_luong,
            'gia_ban' => $giaBanBt,
            'gia_sale' => $giaSaleBt,
        ]);
        $this->luu_hinh_anh_bien_the($bienThe, $request);

        return back()->with('success', 'Thêm biến thể thành công');
    }

    public function sua_bien_the(Request $request, $id)
    {
        $request->validate([
            'gia_tri_bien_the' => 'required|array',
            'so_luong' => 'required|integer|min:0',
            'gia_ban' => 'nullable|numeric|min:0',
            'gia_sale' => 'nullable|numeric|min:0',
            'hinh_anh' => 'nullable|array',
            'hinh_anh.*' => 'image|max:5120',
            'xoa_hinh_anh' => 'nullable|array',
            'xoa_hinh_anh.*' => 'integer|exists:product_variant_images,id',
        ]);
        $bienThe = ProductVariant::with('product')->findOrFail($id);
        $sanPham = $bienThe->product;
        $giaBanBt = $this->gia_so_hoac_null($request, 'gia_ban');
        $giaSaleBt = $this->gia_so_hoac_null($request, 'gia_sale');
        $loi = GiaSanPhamValidator::loiGiaBienThe($sanPham, $giaBanBt, $giaSaleBt);
        if ($loi) {
            return back()->withErrors(['gia_bien_the' => $loi])->withInput();
        }
        $bienThe->update([
            'gia_tri_bien_the' => json_encode($request->gia_tri_bien_the),
            'so_luong' => $request->so_luong,
            'gia_ban' => $giaBanBt,
            'gia_sale' => $giaSaleBt,
        ]);
        if ($request->filled('xoa_hinh_anh')) {
            $this->xoa_hinh_anh_da_chon($bienThe, $request->xoa_hinh_anh);
        }
        $this->luu_hinh_anh_bien_the($bienThe, $request);

        return back()->with('success', 'Cập nhật biến thể thành công');
    }

    public function xoa_bien_the($id)
    {
        $bienThe = ProductVariant::with('images')->findOrFail($id);
        foreach ($bienThe->images as $img) {
            if ($img->hinh_anh) {
                Storage::disk('public')->delete($img->hinh_anh);
            }
        }
        $bienThe->delete();

        return back()->with('success', 'Xóa biến thể thành công');
    }

    private function gia_so_hoac_null(Request $request, string $key): ?float
    {
        $v = $request->input($key);
        if ($v === null || $v === '') {
            return null;
        }

        return (float) $v;
    }

    private function luu_hinh_anh_bien_the(ProductVariant $bienThe, Request $request): void
    {
        if (! $request->hasFile('hinh_anh')) {
            return;
        }
        foreach ($request->file('hinh_anh') as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }
            $path = $file->store('variants', 'public');
            $bienThe->images()->create(['hinh_anh' => $path]);
        }
    }

    private function xoa_hinh_anh_da_chon(ProductVariant $bienThe, array $ids): void
    {
        $ids = array_map('intval', $ids);
        $anh = ProductVariantImage::where('product_variant_id', $bienThe->id)->whereIn('id', $ids)->get();
        foreach ($anh as $row) {
            if ($row->hinh_anh) {
                Storage::disk('public')->delete($row->hinh_anh);
            }
            $row->delete();
        }
    }
}

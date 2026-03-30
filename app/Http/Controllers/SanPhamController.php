<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\GiaSanPhamValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SanPhamController extends Controller
{
    public function trang_chu(Request $request)
    {
        $banners = Banner::orderBy('vi_tri')->get();
        $categories = Category::orderBy('ten')->get();

        $query = Product::with(['variants.images', 'category'])->latest();
        if ($request->filled('danh_muc')) {
            $query->where('category_id', (int) $request->danh_muc);
        }
        if ($request->filled('q')) {
            $tuKhoa = trim((string) $request->q);
            if ($tuKhoa !== '') {
                $query->where('ten', 'like', '%'.$tuKhoa.'%');
            }
        }
        $products = $query->paginate(12)->withQueryString(); 

        return view('store.trang_chu', compact('banners', 'products', 'categories'));
    }

    public function hien_thi_chi_tiet($id)
    {
        $product = Product::with(['variants.images', 'category'])->findOrFail($id);

        $goiY = Product::with('variants.images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(6)
            ->get();
        if ($goiY->count() < 4) {
            $them = Product::with('variants.images')
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $goiY->pluck('id'))
                ->inRandomOrder()
                ->take(6 - $goiY->count())
                ->get();
            $goiY = $goiY->merge($them)->take(6)->values();
        }

        return view('store.san_pham.chi_tiet', compact('product', 'goiY'));
    }

    public function danh_sach_theo_danh_muc(Request $request, $id)
    {
        $category = Category::with(['products.variants.images'])->findOrFail($id);
        $sanPhams = $category->products()->with(['variants.images', 'category'])->latest();
        if ($request->filled('q')) {
            $tuKhoa = trim((string) $request->q);
            if ($tuKhoa !== '') {
                $sanPhams->where('ten', 'like', '%'.$tuKhoa.'%');
            }
        }
        $sanPhams = $sanPhams->paginate(12)->withQueryString();

        return view('store.san_pham.danh_sach_theo_danh_muc', compact('category', 'sanPhams'));
    }

    public function danh_sach_san_pham(Request $request)
    {
        $query = Product::with([
            'category.variantTypes',
            'variants.images',
        ])->orderBy('id', 'desc');

        if ($request->filled('danh_muc')) {
            $query->where('category_id', (int) $request->danh_muc);
        }
        if ($request->filled('q')) {
            $tuKhoa = trim((string) $request->q);
            if ($tuKhoa !== '') {
                $query->where('ten', 'like', '%'.$tuKhoa.'%');
            }
        }

        $products = $query->get();
        $categories = Category::orderBy('ten')->get();

        return view('admin.san_pham.danh_sach', compact('products', 'categories'));
    }

    public function form_them_san_pham()
    {
        $categories = Category::with('variantTypes')->orderBy('ten')->get();

        return view('admin.san_pham.them', compact('categories'));
    }

    public function form_sua_san_pham($id)
    {
        $product = Product::with([
            'category.variantTypes',
            'variants.images',
        ])->findOrFail($id);
        $categories = Category::with('variantTypes')->orderBy('ten')->get();

        return view('admin.san_pham.sua', compact('product', 'categories'));
    }

    public function them_san_pham(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'gia_nhap' => 'required|numeric|min:0',
            'gia_ban' => 'required|numeric|min:0',
            'gia_sale' => 'nullable|numeric|min:0',
            'variants' => 'required|array|min:1',
            'variants.*.so_luong' => 'required|integer|min:0',
            'variants.*.gia_tri_bien_the' => 'required|array',
            'variants.*.gia_ban' => 'nullable|numeric|min:0',
            'variants.*.gia_sale' => 'nullable|numeric|min:0',
            'variants.*.hinh_anh' => 'nullable|array',
            'variants.*.hinh_anh.*' => 'image|max:5120',
        ]);

        if ($request->gia_nhap >= $request->gia_ban) {
            return back()->withErrors(['gia_nhap' => 'Giá nhập phải nhỏ hơn giá bán.'])->withInput();
        }
        $giaSale = $request->filled('gia_sale') ? (float) $request->gia_sale : (float) $request->gia_ban;
        if ($giaSale < $request->gia_nhap || $giaSale > $request->gia_ban) {
            return back()->withErrors(['gia_sale' => 'Quy tắc: gia_nhap < gia_sale ≤ gia_ban.'])->withInput();
        }

        $category = Category::with('variantTypes')->findOrFail($request->category_id);
        if ($category->variantTypes->isEmpty()) {
            return back()->withErrors(['category_id' => 'Danh mục chưa gắn loại biến thể. Hãy cập nhật tại Quản lý danh mục.'])->withInput();
        }

        $tenLoai = $category->variantTypes->pluck('ten');
        foreach ($request->variants as $idx => $row) {
            $gt = $row['gia_tri_bien_the'] ?? [];
            foreach ($tenLoai as $t) {
                if (! isset($gt[$t]) || trim((string) $gt[$t]) === '') {
                    return back()->withErrors(['variants' => 'Biến thể #'.($idx + 1).': thiếu giá trị «'.$t.'».'])->withInput();
                }
            }
        }

        try {
            DB::transaction(function () use ($request, $giaSale) {
                $product = Product::create([
                    'ten' => $request->ten,
                    'mo_ta' => $request->mo_ta,
                    'category_id' => $request->category_id,
                    'gia_nhap' => $request->gia_nhap,
                    'gia_ban' => $request->gia_ban,
                    'gia_sale' => $giaSale,
                ]);

                foreach ($request->variants as $i => $row) {
                    $giaBanBt = $this->giaSoHoacNull($row['gia_ban'] ?? null);
                    $giaSaleBt = $this->giaSoHoacNull($row['gia_sale'] ?? null);
                    $loi = GiaSanPhamValidator::loiGiaBienThe($product, $giaBanBt, $giaSaleBt);
                    if ($loi) {
                        throw ValidationException::withMessages(['gia_bien_the' => $loi]);
                    }

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'gia_tri_bien_the' => $row['gia_tri_bien_the'],
                        'so_luong' => $row['so_luong'],
                        'gia_ban' => $giaBanBt,
                        'gia_sale' => $giaSaleBt,
                    ]);

                    $files = $request->file("variants.$i.hinh_anh", []) ?? [];
                    foreach ($files as $file) {
                        if ($file && $file->isValid()) {
                            $path = $file->store('variants', 'public');
                            $variant->images()->create(['hinh_anh' => $path]);
                        }
                    }
                }
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect('/quan_ly_san_pham')->with('success', 'Đã tạo sản phẩm và các biến thể.');
    }

    public function sua_san_pham(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'gia_nhap' => 'required|numeric|min:0',
            'gia_ban' => 'required|numeric|min:0',
            'gia_sale' => 'nullable|numeric|min:0',
        ]);
        if ($request->gia_nhap >= $request->gia_ban) {
            return back()->withErrors(['gia_nhap' => 'Giá nhập phải nhỏ hơn giá bán.'])->withInput();
        }
        $giaSale = $request->filled('gia_sale') ? (float) $request->gia_sale : (float) $request->gia_ban;
        if ($giaSale < $request->gia_nhap || $giaSale > $request->gia_ban) {
            return back()->withErrors(['gia_sale' => 'Quy tắc: gia_nhap < gia_sale ≤ gia_ban.'])->withInput();
        }
        $product = Product::findOrFail($id);
        $product->update([
            'ten' => $request->ten,
            'mo_ta' => $request->mo_ta,
            'category_id' => $request->category_id,
            'gia_nhap' => $request->gia_nhap,
            'gia_ban' => $request->gia_ban,
            'gia_sale' => $giaSale,
        ]);

        return redirect('/quan_ly_san_pham/sua/'.$id)->with('success', 'Đã cập nhật thông tin sản phẩm.');
    }

    public function xoa_san_pham($id)
    {
        Product::destroy($id);

        return redirect('/quan_ly_san_pham')->with('success', 'Đã xóa sản phẩm.');
    }

    private function giaSoHoacNull(mixed $v): ?float
    {
        if ($v === null || $v === '') {
            return null;
        }

        return (float) $v;
    }
}

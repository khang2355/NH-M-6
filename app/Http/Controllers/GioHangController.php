<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class GioHangController extends Controller
{
    public function hien_thi_gio_hang()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with(['variant.product.variants.images', 'variant.images'])->get();

        $goiY = collect();
        if ($items->isEmpty()) {
            $goiY = Product::with('variants.images')->inRandomOrder()->take(6)->get();
        } else {
            $productIdsInCart = $items->map(fn ($i) => $i->variant?->product_id)->filter()->unique()->values();
            $catIds = Product::whereIn('id', $productIdsInCart)->pluck('category_id')->unique()->filter();
            $goiY = Product::with('variants.images')
                ->whereIn('category_id', $catIds)
                ->whereNotIn('id', $productIdsInCart)
                ->inRandomOrder()
                ->take(6)
                ->get();
            if ($goiY->count() < 4) {
                $need = 6 - $goiY->count();
                $more = Product::with('variants.images')
                    ->whereNotIn('id', $productIdsInCart)
                    ->inRandomOrder()
                    ->take($need)
                    ->get();
                $goiY = $goiY->merge($more)->unique('id')->take(6)->values();
            }
        }

        return view('store.gio_hang', compact('cart', 'items', 'goiY'));
    }
    public function them_san_pham_gio_hang(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'so_luong' => 'required|integer|min:1',
        ]);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $item = $cart->items()->where('product_variant_id', $request->product_variant_id)->first();
        if ($item) {
            $item->increment('so_luong', $request->so_luong);
        } else {
            $cart->items()->create([
                'product_variant_id' => $request->product_variant_id,
                'so_luong' => $request->so_luong,
            ]);
        }
        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }
    public function cap_nhat_gio_hang(Request $request)
    {
        foreach ($request->input('items', []) as $itemId => $soLuong) {
            CartItem::where('id', $itemId)->update(['so_luong' => max(1, (int) $soLuong)]);
        }
        return back()->with('success', 'Cập nhật giỏ hàng thành công');
    }
    public function xoa_san_pham_gio_hang($id)
    {
        CartItem::destroy($id);
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }
    public function tinh_tong_tien()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load(['items.variant.product']);
        $tong = 0;
        foreach ($cart->items as $item) {
            $tong += $item->so_luong * $item->variant->gia_thanh_toan();
        }

        return response()->json(['tong_tien' => $tong]);
    }
}

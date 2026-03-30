<?php

namespace App\Services;

use App\Models\Product;

class GiaSanPhamValidator
{
    /**
     * Quy tắc: giá bán hiệu lực > giá nhập SP; sale ≤ bán và nếu sale < bán thì sale > nhập.
     */
    public static function loiGiaBienThe(Product $sanPham, ?float $giaBanBienThe, ?float $giaSaleBienThe): ?string
    {
        $ban = $giaBanBienThe ?? (float) $sanPham->gia_ban;
        $sale = $giaSaleBienThe !== null ? (float) $giaSaleBienThe : (float) ($sanPham->gia_sale ?? $ban);
        $nhap = (float) $sanPham->gia_nhap;

        if ($ban <= $nhap) {
            return 'Giá bán (mặc định hoặc riêng biến thể) phải lớn hơn giá nhập sản phẩm.';
        }
        if ($sale > $ban) {
            return 'Giá sale phải nhỏ hơn hoặc bằng giá bán hiệu lực.';
        }
        if ($sale < $ban && $sale <= $nhap) {
            return 'Khi có khuyến mãi, giá sale phải lớn hơn giá nhập sản phẩm.';
        }

        return null;
    }
}

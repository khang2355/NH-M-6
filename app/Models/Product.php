<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten', 'mo_ta', 'category_id', 'gia_nhap', 'gia_ban', 'gia_sale',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /** Giá hiển thị trên thẻ sản phẩm (khi không xét từng biến thể). */
    public function gia_mac_dinh_hien_thi(): float
    {
        $ban = (float) $this->gia_ban;
        $sale = (float) ($this->gia_sale ?? $ban);

        return ($sale < $ban) ? $sale : $ban;
    }

    /** Chuỗi giá cho danh sách: "Từ xđ" nếu biến thể khác giá. */
    public function khoang_gia_hien_thi(): string
    {
        if (! $this->relationLoaded('variants')) {
            $this->load('variants');
        }
        if ($this->variants->isEmpty()) {
            return number_format($this->gia_mac_dinh_hien_thi()).'đ';
        }
        $prices = $this->variants->map(fn (ProductVariant $v) => $v->gia_thanh_toan($this));
        $min = $prices->min();
        $max = $prices->max();
        if ($min === $max) {
            return number_format($min).'đ';
        }

        return 'Từ '.number_format($min).'đ';
    }

    public function co_bien_the_dang_sale(): bool
    {
        if (! $this->relationLoaded('variants')) {
            $this->load('variants');
        }

        return $this->variants->contains(fn (ProductVariant $v) => $v->co_hien_thi_nhan_sale($this));
    }
}

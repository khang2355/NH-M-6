<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'gia_tri_bien_the', 'so_luong', 'gia_ban', 'gia_sale',
    ];

    protected function casts(): array
    {
        return [
            'gia_tri_bien_the' => 'json',
            'gia_ban' => 'decimal:2',
            'gia_sale' => 'decimal:2',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->hasMany(ProductVariantImage::class, 'product_variant_id');
    }

    /** Giá bán hiển thị: riêng biến thể hoặc theo sản phẩm. */
    public function gia_ban_hien_thi(?Product $sanPham = null): float
    {
        $p = $sanPham ?? ($this->relationLoaded('product') ? $this->getRelation('product') : $this->product()->first());

        return $this->gia_ban !== null && $this->gia_ban !== ''
            ? (float) $this->gia_ban
            : (float) $p->gia_ban;
    }

    /** Giá sale (null = theo sản phẩm). */
    public function gia_sale_hien_thi(?Product $sanPham = null): ?float
    {
        $p = $sanPham ?? ($this->relationLoaded('product') ? $this->getRelation('product') : $this->product()->first());

        if ($this->gia_sale !== null && $this->gia_sale !== '') {
            return (float) $this->gia_sale;
        }

        $gs = $p->gia_sale ?? null;

        return $gs !== null ? (float) $gs : null;
    }

    /** Giá thực tế khách trả (đã áp sale nếu hợp lệ). */
    public function gia_thanh_toan(?Product $sanPham = null): float
    {
        $ban = $this->gia_ban_hien_thi($sanPham);
        $sale = $this->gia_sale_hien_thi($sanPham);
        if ($sale === null) {
            return $ban;
        }

        return ($sale < $ban) ? $sale : $ban;
    }

    public function co_hien_thi_nhan_sale(?Product $sanPham = null): bool
    {
        $ban = $this->gia_ban_hien_thi($sanPham);
        $sale = $this->gia_sale_hien_thi($sanPham);

        return $sale !== null && $sale < $ban;
    }

    protected function giaTriBienThe(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->normalizeGiaTri($value),
            set: fn (mixed $value) => $this->normalizeGiaTriForStorage($value),
        );
    }

    private function normalizeGiaTri(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if ($value === null || $value === '') {
            return [];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            if (is_string($decoded)) {
                $decoded2 = json_decode($decoded, true);

                return is_array($decoded2) ? $decoded2 : [];
            }
        }

        return [];
    }

    private function normalizeGiaTriForStorage(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            return json_encode($value);
        }
        if ($value === null || $value === '') {
            return '{}';
        }

        return '{}';
    }
}

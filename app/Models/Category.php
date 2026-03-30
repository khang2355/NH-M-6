<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['ten', 'mo_ta', 'hinh_anh'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function variantTypes()
    {
        return $this->belongsToMany(VariantType::class, 'category_variant_type');
    }
}

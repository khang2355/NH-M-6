<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantType extends Model
{
    use HasFactory;

    protected $fillable = ['ten'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_variant_type');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image'
    ];

    // 1 ProductImage thuộc về 1 Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Deltail extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDeltailFactory> */
    use HasFactory;
    protected $fillable = [
        'description',
        'category',
        'brand'
    ];

    // Relationships
      public function products(){
        return $this->belongsTo(Product::class, 'product_id');
      }
}

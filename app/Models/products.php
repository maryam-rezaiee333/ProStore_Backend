<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\productDetails;
use App\Models\Image;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'price',
    ];

    public function productDetails()
    {
        return $this->hasOne(productDetails::class, 'product_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
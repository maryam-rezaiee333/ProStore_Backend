<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewsFactory> */
    use HasFactory;
    protected $fillable = [
        "rating",
        "comment",
        "product_id",
        "user_id"
    ];
    public function products(){
        return $this->belongsTo(products::class , "product_id");    
    }
     public function users(){
        return $this->belongsTo(User::class , "user_id");    
    }
}

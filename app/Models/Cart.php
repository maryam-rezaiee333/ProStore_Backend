<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cartItem_id'
    ];

    // Relationships
   public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
       public function cartItem(){
        return $this->belongsTo(CartItem::class, 'cartItem_id'); 
    }
}

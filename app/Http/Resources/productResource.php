<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=>$this->name,
            "stock"=>$this->stock,
            "price"=>$this->price,
            "brand"=>$this->productDetails->brand,
            "description"=>$this->productDetails->description,
            "catagory"=>$this->productDetails->catagory,
            "image_url"=>$this->images->map(function($images){
                return asset('storage/'.$images->img_url);
            }),
        ];
    }
}

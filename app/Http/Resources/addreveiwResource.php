<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class addreveiwResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "rating"=> $this->rating,
            "comment"=> $this->comment,
            "user-name"=>$this->users->name,
            "product-name"=> $this->products->name,
        ];
    }
}

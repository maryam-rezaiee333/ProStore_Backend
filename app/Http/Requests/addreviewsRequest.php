<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class addreviewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "comment"=> "nullable|string|min:4",
            "rating"=> "required|integer|min:0",
            "user_id"=> "required|integer|exists:users,id",
            "product_id"=> "required|integer|exists:products,id",
        ];
    }
}

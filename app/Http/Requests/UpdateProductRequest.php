<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            //
            // 'name'=> ['required' ,'string','min:3', Rule::unique('products','name')],
            'name'=> 'nullable|string|min:3',
            'price'=> 'nullable|decimal|min:20',
            'stock'=> 'nullable|integer|min:1',
            'brand'=> 'required|string',
            'description'=> 'required|string|min:10',
            'category'=> 'nullable|string|min:3',
            'image_url'=> 'nullable|image|mimes: jpg, png, jpeg, gif, webp',
            'imageable_type'=> 'required|string',
            'imageable_id'=> 'required|integer',
        ];
    }
}

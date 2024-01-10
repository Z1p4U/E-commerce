<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique:products,name",
            // 'category_ids' => 'required|array',
            // 'category_ids.*' => 'exists:categories,id',
            // 'brand_ids' => 'required|array',
            // "brand_ids.*" => "exists:brands,id",
            "short_description" => "required",
            "description" => "required",
            "photo" => "nullable"
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            "name" => "required|unique:items,name",
            "product_id" => "required",
            "sku" => "required|unique:items,sku",
            "size" => "required",
            "sale" => "nullable|boolean",
            "price" => "required",
            "discount_price" => "nullable",
            "description" => "nullable",
            "photo" => "nullable"
        ];
    }
}

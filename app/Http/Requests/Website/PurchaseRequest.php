<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest

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
            "photo" => "required|file|max:2048|mimes:png,jpg,jpeg",
        ];
    }
}

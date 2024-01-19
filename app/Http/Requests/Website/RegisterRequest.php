<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "user_name" => "required|min:3|max:30|unique:users,user_name",
            "name" => "required|min:3|max:30|unique:users,name",
            "phone" => "required",
            "viber" => "required",
            "address" => "required",
            "email" => "email|required|unique:users",
            "password" => "required|confirmed|min:6",
        ];
    }
}

<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            "user_name" => "nullable|min:3|max:30|unique:users,user_name",
            "name" => "nullable|min:3|max:30|unique:users,name",
            "phone" => "nullable",
            "viber" => "nullable",
            "email" => "email",
        ];
    }
}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|numeric|min:8|unique:users,phone_number',
            // 'image_path' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:6|max:24'
            // 'password' => ['required', Password::min(6)->mixedCase()->symbols()],
        ];
    }
}

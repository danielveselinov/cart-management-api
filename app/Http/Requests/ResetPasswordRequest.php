<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required|exists:password_resets,token',
            'email' => 'required|string|email',
            'password' => ['required', 'confirmed', 'max:24', Password::min(6)->mixedCase()->symbols()],
            'password_confirmation' => 'required'
        ];
    }
}

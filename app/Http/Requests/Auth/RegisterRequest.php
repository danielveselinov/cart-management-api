<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="RegisterRequest",
 *      description="Register a new user",
 *      type="object",
 *      required={"name", "email", "phone_number", "password"}
 * )
 */
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
     * @OA\Property(
     *      property="name",
     *      title="Full name",
     *      description="Enter your full name"
     * ),
     * @OA\Property(
     *      property="email",
     *      title="Email address",
     *      description="Enter your email address",
     * ),
     * @OA\Property(
     *      property="phone_number",
     *      title="Phone Number",
     *      description="Enter your phone number",
     * ),
     * @OA\Property(
     *      property="password",
     *      title="Password",
     *      description="Enter a password for your account",
     * ),
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|numeric|min:8|unique:users,phone_number',
            'password' => ['required', Password::min(6)->mixedCase()->symbols()],
        ];
    }
}

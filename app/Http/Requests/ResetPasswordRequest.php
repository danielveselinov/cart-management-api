<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *      title="ResetPasswordRequest",
 *      description="Reset password request",
 *      type="object",
 *      required={"email"}
 * )
 */
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
     * @OA\Property(
     *      property="token",
     *      title="Token",
     *      description="Enter token",
     * ),
     * @OA\Property(
     *      property="email",
     *      title="Email address",
     *      description="Enter your email address to continue",
     *      example="john.doe@example.com"
     * ),
     * @OA\Property(
     *      property="password",
     *      title="New password",
     *      description="Enter your new password",
     * ),
     * @OA\Property(
     *      property="password_confirmation",
     *      title="Password Confirmation",
     *      description="Repeat your password",
     * ),
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

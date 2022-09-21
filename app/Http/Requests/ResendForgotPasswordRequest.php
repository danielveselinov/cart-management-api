<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="ResendForgotPasswordRequest",
 *      description="Resend verification token via email",
 *      type="object",
 *      required={"email"}
 * )
 */
class ResendForgotPasswordRequest extends FormRequest
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
     *      property="email",
     *      title="Email address",
     *      description="Enter your email address to continue",
     *      example="john.doe@example.com"
     * ),
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email'
        ];
    }
}

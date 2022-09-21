<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="LoginRequest",
 *      description="Login user request",
 *      type="object",
 *      required={"login", "password"}
 * )
 */
class LoginRequest extends FormRequest
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
     *      property="login",
     *      title="Email address or Phone Number",
     *      description="Enter your email address or phone number",
     *      example="john.doe@example.com"
     * ),
     * @OA\Property(
     *      property="password",
     *      title="Password",
     *      description="Enter your password",
     *      example="password"
     * ),
     * 
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string'
        ];
    }
}

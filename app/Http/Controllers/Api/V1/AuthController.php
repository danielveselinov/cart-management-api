<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ResendForgotPasswordRequest;
use App\Http\Requests\ResendVerificationCodeRequest;
use App\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->orWhere('phone_number', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Please verify your account.']);
        }

        $authToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $authToken], Response::HTTP_ACCEPTED);
    }

    public function register(RegisterRequest $request)
    {
        $code = rand(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'verification_code' => $code,
        ]);

        event(new Registered($user));

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function verifyAccount(Request $request)
    {
        $user = User::where('id', '=', $request->id)
            ->where('verification_code', '=', $request->code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        $user->is_active = 1;
        $user->verification_code = null;

        $user->update();

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function resendVerificationCode(ResendVerificationCodeRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        $user->verification_code = rand(1000, 9999);
        $user->save();

        event(new Registered($user));

        return response()->json(['message' => 'The code was sent to your email account: ' . $request->email]);
    }

    public function forgetPassword(ResendForgotPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        $code = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $code,
            'created_at' => now()
        ]);

        event(new ForgotPassword($user, $code));

        return response()->json(['message' => 'The code was sent to your email account: ' . $request->email]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return response()->json(['success' => true, 'message' => 'Password updated']);
    }

    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        $token->delete();

        return response()->json(['message' => 'Logged out.'], Response::HTTP_ACCEPTED);
    }
}

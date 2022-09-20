<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->orWhere('phone_number', $request->login)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'Please verify your account.']);
        }

        // create token
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

        if (! $user) {
            return response()->json(['message' => 'The given data was invalid.']);
        }

        $user->is_active = 1;
        $user->verification_code = null;

        $user->update();

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        $token->delete();

        return response()->json(['message' => 'Logged out.'], Response::HTTP_ACCEPTED);
    }
}

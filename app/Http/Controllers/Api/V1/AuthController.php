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
    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="login",
     *      tags={"Users"},
     *      summary="Login an existing user",
     *      description="Generates a Bearer auth token for the user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="New token being created",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->orWhere('phone_number', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The given data was invalid.'], Response::HTTP_BAD_REQUEST);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Please verify your account.'], Response::HTTP_FORBIDDEN);
        }

        $authToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $authToken], Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      operationId="register",
     *      tags={"Users"},
     *      summary="Register a new user",
     *      description="Register a new user into our database",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="New resources being created",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     *      path="/api/v1/verify-account",
     *      operationId="verifyAccount",
     *      tags={"Users"},
     *      summary="Update (activate) existing user",
     *      description="Returns updated user",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="verification_code",
     *          description="Generateed code",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function verifyAccount(Request $request)
    {
        $user = User::where('id', '=', $request->id)
            ->where('verification_code', '=', $request->code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.'], Response::HTTP_BAD_REQUEST);
        }

        $user->is_active = 1;
        $user->verification_code = null;

        $user->update();

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/resend-code",
     *      operationId="resendCode",
     *      tags={"Users"},
     *      summary="Resend a verification code",
     *      description="Resend a veriication code via email",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ResendVerificationCodeRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function resendVerificationCode(ResendVerificationCodeRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.'], Response::HTTP_BAD_REQUEST);
        }

        $user->verification_code = rand(1000, 9999);
        $user->save();

        event(new Registered($user));

        return response()->json(['message' => 'The code was sent to your email account: ' . $request->email], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/forget-password",
     *      operationId="forgetPassword",
     *      tags={"Users"},
     *      summary="Resend a verification token",
     *      description="Resend a veriication token via email",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ResendForgotPasswordRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function forgetPassword(ResendForgotPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.'], Response::HTTP_BAD_REQUEST);
        }

        $code = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $code,
            'created_at' => now()
        ]);

        event(new ForgotPassword($user, $code));

        return response()->json(['message' => 'The code was sent to your email account: ' . $request->email], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/reset-password",
     *      operationId="resetPassword",
     *      tags={"Users"},
     *      summary="Reset password",
     *      description="Reset password",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ResetPasswordRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$user) {
            return response()->json(['message' => 'The given data was invalid.'], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return response()->json(['success' => true, 'message' => 'Password updated'], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      operationId="logout",
     *      tags={"Users"},
     *      summary="Logout",
     *      description="Destor current access (bearer) token",
     *      @OA\Parameter(
     *          name="token",
     *          description="Bearer token",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        $token->delete();

        return response()->json(['message' => 'Logged out.'], Response::HTTP_ACCEPTED);
    }
}

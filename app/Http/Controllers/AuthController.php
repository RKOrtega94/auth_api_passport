<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param Request $request
     * @return JsonResponse
     */
    function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);

            Log::info($credentials);

            if (!$token = auth()->attempt($credentials)) {
                Log::info('Unauthorized');
                return $this->sendError('Unauthorized', [], 401);
            }

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken(env('APP_KEY'))->accessToken;

            return $this->sendResponse(['token' => $token, 'user' => $user], 'User login successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    /**
     * Register user and create token
     *
     * @param Request $request
     * @return JsonResponse
     */
    function register(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            $user->assignRole('user');

            return $this->sendResponse($user, 'User register successfully.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    /**
     * Forgot password
     *
     * @param Request $request
     * @return JsonResponse
     */
    function forgotPassword(Request $request): JsonResponse
    {
        try {
            $email = $request->email;

            $user = User::where('email', $email)->first();

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            // Temp code random 6 digits
            $code = rand(100000, 999999);

            $user->code = Hash::make($code);

            $user->save();

            // Send SMS to user
            $this->sendSMS($user->phone, "Your code is: $code");

            return $this->sendResponse($user->name, 'Code sent successfully to your phone ' . $user->phone);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    function logout(Request $request): JsonResponse
    {
        try {
            Log::info($request->user()->token());

            $request->user()->token()->revoke();

            return $this->sendResponse([], 'User logout successfully.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }
}

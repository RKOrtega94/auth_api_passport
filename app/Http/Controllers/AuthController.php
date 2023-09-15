<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

            if (!$token = auth()->attempt($credentials)) {
                return $this->sendError('Unauthorized', [], 401);
            }

            $user = auth()->user();

            return $this->sendResponse(['token' => $token, 'user' => $user], 'User login successfully.');
        } catch (\Throwable $th) {
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

            $user->token = $user->createToken('secret')->plainTextToken;

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
}

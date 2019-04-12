<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class AuthController extends Controller
{
    const INVALID_EMAIL = 'Invalid email or password.';
    const FAILED_TOKEN = 'something went wrong!';
    const LOGOUT_MESSAGE = 'User logged out successfully.';

    public function login(LoginRequest $request)
    {
        $remember_token = $request->get('remember_token');
        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        $request->merge([$field => $request->input('email')]);
        $credentials = $request->only($field, 'password');

        $expiration = (!empty($remember_token)) ? Carbon::now('UTC')->addDays(2)->getTimestamp() : Carbon::now('UTC')->addMinutes(300)->getTimestamp();
        try {
            if (!$token = JWTAuth::attempt($credentials, ['exp' => $expiration])) {
                return response()->json(['success' => false, 'message' => self::INVALID_EMAIL], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'message' => self::FAILED_TOKEN], 500);
        }

        return response()->json(['success' => true, 'token' => $token, 'user' => Auth::user()], JsonResponse::HTTP_OK);
    }

    public function logout()
    {
        Auth::logout();
        auth()->logout(true);
        return response()->json(['success' => true, 'message' => self::LOGOUT_MESSAGE], JsonResponse::HTTP_OK);
    }

    public function refreshToken(Request $request)
    {
        try {
            JWTAuth::setToken($request->get('token'));
            $refreshed_token = JWTAuth::refresh($request->get('token'));
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'message' => self::FAILED_TOKEN], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['success' => true, 'token' => $refreshed_token], JsonResponse::HTTP_OK);
    }

    public function getVersion()
    {
        return response()->json(['success' => true, 'api_version' => config('axis.api_version'), 'app_version' => config('axis.app_version'), 'android_app_version' => config('axis.android_app_version'), 'force_update' => config('axis.force_update')], JsonResponse::HTTP_OK);
    }



}

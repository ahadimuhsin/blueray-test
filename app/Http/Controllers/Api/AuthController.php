<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Services\AuthService;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $data = $request->validated();

        try {
            $response = $authService->register($data);

            return ResponseFormatter::success($response, "Successfully registered", HttpResponse::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage());
        }

    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $data = $request->validated();

        try {
            $response = $authService->login($data);

            return ResponseFormatter::success($response, "Login Success", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function logout(AuthService $authService)
    {
        try {
            $authService->logout();

            return ResponseFormatter::success([], "Logout Success", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }
}

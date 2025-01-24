<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function register(array $request)
    {
        try {
            // save data to users table
            $user = User::create($request);

            return $user;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception("Register Failed", 500);
        }
    }

    public function login(array $request)
    {
        try {
            $email = $request["email"];
            $password = $request["password"];

            if (!Auth::attempt(["email" => $email, "password" => $password])) {
                throw new Exception("Email or password is invalid", 401);
            }

            $user = Auth::user();

            $token = $user->createToken("create-token-for-".$user->email);

            return ["user" => $user, "token" => $token->plainTextToken];

        }
         catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception("Email or password is invalid", $e->getCode());
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();

            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}

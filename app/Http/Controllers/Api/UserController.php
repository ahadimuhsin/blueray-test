<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserController extends Controller
{
    public function index(Request $request, UserService $userService)
    {
        try{
            $response = $userService->index($request);

            return ResponseFormatter::success($response, "List Users", HttpResponse::HTTP_OK);
        }
        catch(Exception $e){
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function show($id, Request $request, UserService $userService)
    {
        try{
            $response = $userService->show($id, $request);

            return ResponseFormatter::success($response, "User Details", HttpResponse::HTTP_OK);
        }
        catch(Exception $e){
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function update($id, UpdateUserRequest $request, UserService $userService)
    {
        try {

            $response = $userService->update($id, $request);

            return ResponseFormatter::success($response, "Update User Success", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id, Request $request, UserService $userService)
    {
        try {
            $userService->destroy($id, $request);

            return ResponseFormatter::success([], "User deleted successfully", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

}

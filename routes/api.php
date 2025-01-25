<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;

Route::get('v1/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    Route::middleware("auth:sanctum")->group(function(){
        Route::get("users", [UserController::class, "index"]);
        Route::get("users/{id}", [UserController::class, "show"]);
        Route::put("users/{id}", [UserController::class, "update"]);
        Route::delete("users/{id}", [UserController::class, "destroy"]);

        Route::get("orders", [OrderController::class, "index"]);
        Route::get("orders/stats", [OrderController::class, "statistic"]);
        Route::post("orders", [OrderController::class, "store"]);
        Route::get("orders/tracking/{trackingId}", [OrderController::class, "tracking"]);
        Route::post("logout", [AuthController::class, "logout"]);
    });
});

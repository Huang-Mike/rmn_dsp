<?php

use App\Enums\TokenEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::get('refresh-token', [AuthController::class, 'refreshTokens'])->middleware(['auth:sanctum', 'ability:' . TokenEnum::ISSUE_ACCESS_TOKEN->value]);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'ability:' . TokenEnum::ISSUE_VERIFY_TOKEN->value])->group(function () {
    Route::get('/auth/verify-token', [AuthController::class, 'verifyToken']);

    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'create']);
    });

});
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\CharacterCreationController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\OriginController;
use App\Http\Controllers\Api\RaceController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando']);
}); 

Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('character-creation')->group(function () {
        Route::get('options', [CharacterCreationController::class, 'options']);
        Route::post('preview', [CharacterCreationController::class, 'preview']);
    });

    Route::get('races', [RaceController::class, 'index']);
    Route::get('races/{id}', [RaceController::class, 'show']);

    Route::get('classes', [ClassController::class, 'index']);
    Route::get('classes/{id}', [ClassController::class, 'show']);

    Route::get('origins', [OriginController::class, 'index']);
    Route::get('origins/{id}', [OriginController::class, 'show']);

    Route::patch('characters/{id}/state', [CharacterController::class, 'updateState']);
    Route::apiResource('characters', CharacterController::class);
});
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\CharacterCreationController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CharacterPdfController;
use App\Http\Controllers\Api\CharacterPowerController;
use App\Http\Controllers\Api\CharacterSpellController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\DeityController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OriginController;
use App\Http\Controllers\Api\PowerController;
use App\Http\Controllers\Api\RaceController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SpellController;
use App\Http\Controllers\Api\WeaponController;
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

    Route::get('deities', [DeityController::class, 'index']);
    Route::get('deities/{id}', [DeityController::class, 'show']);

    Route::get('skills', [SkillController::class, 'index']);
    Route::get('skills/{id}', [SkillController::class, 'show']);

    Route::get('weapons', [WeaponController::class, 'index']);
    Route::get('weapons/{id}', [WeaponController::class, 'show']);

    Route::get('items', [ItemController::class, 'index']);
    Route::get('items/{id}', [ItemController::class, 'show']);

    Route::get('powers', [PowerController::class, 'index']);
    Route::get('powers/{id}', [PowerController::class, 'show']);

    Route::get('spells', [SpellController::class, 'index']);
    Route::get('spells/{id}', [SpellController::class, 'show']);

    Route::patch('characters/{id}/state', [CharacterController::class, 'updateState']);
    Route::get('characters/{id}/levelup/preview', [CharacterController::class, 'levelUpPreview']);
    Route::post('characters/{id}/levelup', [CharacterController::class, 'levelUp']);

    // Gestão de poderes do personagem (pré-requisitos + notas)
    Route::get('characters/{id}/powers/{powerId}/check', [CharacterPowerController::class, 'check']);
    Route::post('characters/{id}/powers', [CharacterPowerController::class, 'store']);
    Route::patch('characters/{id}/powers/{instanceId}', [CharacterPowerController::class, 'update']);
    Route::delete('characters/{id}/powers/{instanceId}', [CharacterPowerController::class, 'destroy']);

    // Conjuração: prévia (custo + CD + alerta de PM) e gasto efetivo de PM
    Route::post('characters/{id}/spells/preview', [CharacterSpellController::class, 'preview']);
    Route::post('characters/{id}/spells/cast', [CharacterSpellController::class, 'cast']);

    // Campanhas / Painel do Mestre
    Route::get('campaigns', [CampaignController::class, 'index']);
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::post('campaigns/join', [CampaignController::class, 'join']);
    Route::get('campaigns/{id}', [CampaignController::class, 'show']);
    Route::get('campaigns/{id}/party', [CampaignController::class, 'party']);
    Route::delete('campaigns/{id}/leave', [CampaignController::class, 'leave']);
    Route::patch('characters/{id}/campaign', [CharacterController::class, 'setCampaign']);

    // Exportação PDF da ficha
    Route::get('characters/{id}/export/pdf', [CharacterPdfController::class, 'export']);

    Route::apiResource('characters', CharacterController::class);
});
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Power;
use App\Services\PowerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterPowerController extends Controller
{
    public function __construct(private readonly PowerService $powerService)
    {
    }

    /**
     * Pré-visualiza se o personagem cumpre os pré-requisitos de um poder do catálogo.
     */
    public function check(int $characterId, int $powerId): JsonResponse
    {
        $character = $this->findCharacter($characterId);
        $power = Power::query()->findOrFail($powerId);

        return response()->json($this->powerService->checkPrerequisites($character, $power));
    }

    /**
     * Adiciona um poder do catálogo ao personagem (valida pré-requisitos).
     */
    public function store(Request $request, int $characterId): JsonResponse
    {
        $data = $request->validate([
            'power_id' => ['required', 'integer', 'exists:powers,id'],
            'notes'    => ['nullable', 'string', 'max:1000'],
        ]);

        $character = $this->findCharacter($characterId);
        $power = Power::query()->findOrFail($data['power_id']);

        $character = $this->powerService->attachPower($character, $power, $data['notes'] ?? null);

        return response()->json(
            $character->load(['race', 'characterClass', 'origin', 'classes', 'deityRelation']),
            201
        );
    }

    /**
     * Atualiza a nota de um poder do personagem.
     */
    public function update(Request $request, int $characterId, string $instanceId): JsonResponse
    {
        $data = $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $character = $this->findCharacter($characterId);
        $character = $this->powerService->updateNotes($character, $instanceId, $data['notes'] ?? null);

        return response()->json($character);
    }

    /**
     * Remove um poder do personagem.
     */
    public function destroy(int $characterId, string $instanceId): JsonResponse
    {
        $character = $this->findCharacter($characterId);
        $character = $this->powerService->detachPower($character, $instanceId);

        return response()->json($character);
    }

    private function findCharacter(int $id): Character
    {
        return Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }
}

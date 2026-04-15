<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterRequest;
use App\Models\Character;
use App\Models\Race;
use App\Services\CharacterCreationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function __construct(private readonly CharacterCreationService $service)
    {
    }

    public function index(): JsonResponse
    {
        $characters = Character::query()
            ->with(['race', 'characterClass', 'origin'])
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return response()->json($characters);
    }

    public function store(StoreCharacterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->service->validateAttributes($data);
        $this->service->validateOriginBenefits(
            (int) $data['origin_id'],
            $data['origin_benefits'] ?? []
        );

        $data['level'] = $data['level'] ?? 1;

        // Aplica o modificador racial de Constituição na fórmula de PV
        $race = Race::query()->find((int) $data['race_id']);
        $racialConBonus = (int) (($race?->attribute_modifiers['fixed']['constitution'] ?? 0));
        $finalConstitution = (int) $data['constitution'] + $racialConBonus;

        $resources = $this->service->calculateResources(
            (int) $data['class_id'],
            (int) $data['level'],
            $finalConstitution
        );

        $data['max_hp']     = $resources['max_hp'];
        $data['max_mp']     = $resources['max_mp'];
        $data['current_hp'] = $resources['max_hp'];
        $data['current_mp'] = $resources['max_mp'];
        $data['defense']    = $data['defense'] ?? 10 + (int) $data['dexterity'];
        $data['size']       = $data['size'] ?? 'Médio';
        $data['displacement'] = $data['displacement'] ?? '9m';

        $character = Character::query()->create($data);

        return response()->json(
            $character->load(['race', 'characterClass', 'origin']),
            201
        );
    }

    public function show(int $id): JsonResponse
    {
        $character = Character::query()
            ->with(['race', 'characterClass', 'origin'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($character);
    }

    public function update(StoreCharacterRequest $request, int $id): JsonResponse
    {
        $character = Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->service->validateAttributes($data);
        $this->service->validateOriginBenefits(
            (int) $data['origin_id'],
            $data['origin_benefits'] ?? []
        );

        $resources = $this->service->calculateResources(
            (int) $data['class_id'],
            (int) ($data['level'] ?? $character->level ?? 1),
            (int) $data['constitution']
        );

        $data['max_hp'] = $resources['max_hp'];
        $data['max_mp'] = $resources['max_mp'];

        $character->update($data);

        return response()->json($character->load(['race', 'characterClass', 'origin']));
    }

    public function updateState(Request $request, int $id): JsonResponse
    {
        $character = Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'current_hp'    => 'sometimes|integer',
            'current_mp'    => 'sometimes|integer|min:0',
            'money_gold'    => 'sometimes|integer|min:0',
            'money_silver'  => 'sometimes|integer|min:0',
            'money_copper'  => 'sometimes|integer|min:0',
            'weapons'       => 'sometimes|array',
            'equipment'     => 'sometimes|array',
            'spells'        => 'sometimes|array',
            'powers'        => 'sometimes|array',
            'avatar_url'    => 'sometimes|nullable|url|max:500',
        ]);

        $character->update($validated);

        return response()->json($character->load(['race', 'characterClass', 'origin']));
    }

    public function destroy(int $id): JsonResponse
    {
        $character = Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $character->delete();

        return response()->json(['message' => 'Personagem removido com sucesso.']);
    }
}

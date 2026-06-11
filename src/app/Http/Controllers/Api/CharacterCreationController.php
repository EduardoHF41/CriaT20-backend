<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterRequest;
use App\Models\CharacterClass;
use App\Models\Deity;
use App\Models\ItemCatalog;
use App\Models\Origin;
use App\Models\Power;
use App\Models\Race;
use App\Models\Skill;
use App\Models\Spell;
use App\Models\WeaponCatalog;
use App\Services\CharacterCreationService;
use Illuminate\Http\JsonResponse;

class CharacterCreationController extends Controller
{
    public function __construct(private readonly CharacterCreationService $service)
    {
    }

    public function options(): JsonResponse
    {
        return response()->json([
            'steps' => $this->service->creationSteps(),
            'attribute_rules' => [
                'point_buy' => [
                    'base_points' => 10,
                    'range' => ['min' => -1, 'max' => 4],
                    'cost_table' => [
                        ['attribute' => -1, 'cost' => -1],
                        ['attribute' => 0, 'cost' => 0],
                        ['attribute' => 1, 'cost' => 1],
                        ['attribute' => 2, 'cost' => 2],
                        ['attribute' => 3, 'cost' => 4],
                        ['attribute' => 4, 'cost' => 7],
                    ],
                ],
                'rolled' => [
                    'formula' => '4d6 descarta o menor, 6 vezes',
                    'range' => ['min' => -2, 'max' => 4],
                    'minimum_sum' => 6,
                ],
            ],
            'races' => Race::query()->orderBy('name')->get(),
            'classes' => CharacterClass::query()->orderBy('name')->get(),
            'origins' => Origin::query()->with('features')->orderBy('name')->get(),
            'deities' => Deity::query()->orderBy('name')->get(),
            'skills' => Skill::query()->orderBy('name')->get(),
            'weapons' => WeaponCatalog::query()->orderBy('category')->orderBy('name')->get(),
            'powers' => Power::query()->whereIn('type', ['geral', 'tormenta'])
                ->orderBy('type')->orderBy('category')->orderBy('name')->get(),
            'spells' => Spell::query()->orderBy('tradition')->orderBy('circle')->orderBy('name')->get(),
            'items' => ItemCatalog::query()->orderBy('type')->orderBy('name')->get(),
        ]);
    }

    public function preview(StoreCharacterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->service->validateAttributes($data);
        $this->service->validateOriginBenefits(
            (int) $data['origin_id'],
            $data['origin_benefits'] ?? []
        );

        $resources = $this->service->calculateResources(
            (int) $data['class_id'],
            (int) ($data['level'] ?? 1),
            (int) $data['constitution']
        );

        $data['max_hp'] = $resources['max_hp'];
        $data['max_mp'] = $resources['max_mp'];

        return response()->json([
            'valid' => true,
            'message' => 'Ficha validada com sucesso para criação.',
            'data' => $data,
            'resources' => $resources,
        ]);
    }
}

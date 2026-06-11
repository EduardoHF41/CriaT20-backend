<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelUpRequest;
use App\Http\Requests\StoreCharacterRequest;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Race;
use App\Services\CharacterCreationService;
use App\Services\LevelUpService;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterCreationService $service,
        private readonly LevelUpService $levelUpService,
        private readonly SkillService $skillService,
    ) {
    }

    public function index(): JsonResponse
    {
        $characters = Character::query()
            ->with(['race', 'characterClass', 'origin', 'classes'])
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

        // Resolve os modificadores raciais (fixo + subtipo + flexível)
        $race        = Race::query()->find((int) $data['race_id']);
        $flexChoices = $data['racial_flex_choices'] ?? [];
        $flexValue   = (int) ($race?->attribute_modifiers['flexible']['value'] ?? 0);
        $subtype     = $data['racial_subtype'] ?? null;

        // Bônus do subtipo escolhido (ex: Suraggel Aggelus → Sab+2, Car+1)
        $subtypeMods = [];
        if ($subtype && isset($race?->attribute_modifiers['subtypes'][$subtype])) {
            $subtypeMods = $race->attribute_modifiers['subtypes'][$subtype];
        }

        $racialConFixed   = (int) ($race?->attribute_modifiers['fixed']['constitution'] ?? 0);
        $racialConSubtype = (int) ($subtypeMods['constitution'] ?? 0);
        $racialConFlex    = in_array('constitution', $flexChoices) ? $flexValue : 0;
        $finalConstitution = (int) $data['constitution'] + $racialConFixed + $racialConSubtype + $racialConFlex;

        $racialIntFixed   = (int) ($race?->attribute_modifiers['fixed']['intelligence'] ?? 0);
        $racialIntSubtype = (int) ($subtypeMods['intelligence'] ?? 0);
        $racialIntFlex    = in_array('intelligence', $flexChoices) ? $flexValue : 0;
        $finalIntelligence = (int) $data['intelligence'] + $racialIntFixed + $racialIntSubtype + $racialIntFlex;

        // Valida a seleção de perícias (catálogo + limite da classe + INT).
        $primaryClass = CharacterClass::query()->findOrFail(
            (int) (($data['classes'][0]['class_id'] ?? null) ?? $data['class_id'])
        );
        $this->skillService->validateSkillSelection(
            $primaryClass,
            $data['trained_skills'] ?? [],
            $finalIntelligence,
            count($data['origin_benefits'] ?? [])
        );

        $multiclass = $data['classes'] ?? null;

        if (!empty($multiclass)) {
            // Multiclasse: calcula recursos somando todas as classes.
            $resources = $this->service->calculateMulticlassResources($multiclass, $finalConstitution);
            $data['level']    = $resources['total_level'];
            $data['class_id'] = (int) $multiclass[0]['class_id']; // classe primária = primeira
        } else {
            $resources = $this->service->calculateResources(
                (int) $data['class_id'],
                (int) $data['level'],
                $finalConstitution
            );
        }

        $data['max_hp']     = $resources['max_hp'];
        $data['max_mp']     = $resources['max_mp'];
        $data['current_hp'] = $resources['max_hp'];
        $data['current_mp'] = $resources['max_mp'];

        $racialDexFixed   = (int) ($race?->attribute_modifiers['fixed']['dexterity'] ?? 0);
        $racialDexSubtype = (int) ($subtypeMods['dexterity'] ?? 0);
        $racialDexFlex    = in_array('dexterity', $flexChoices) ? $flexValue : 0;
        $data['defense'] = $data['defense'] ?? 10 + (int) $data['dexterity'] + $racialDexFixed + $racialDexSubtype + $racialDexFlex;
        $data['size']       = $data['size'] ?? 'Médio';
        $data['displacement'] = $data['displacement'] ?? '9m';

        // Converte nomes de magias para objetos completos (valida pertencimento e limite)
        $data['spells'] = $this->service->resolveInitialSpells(
            (int) $data['class_id'],
            $data['spells'] ?? []
        );

        // Converte nomes de poderes para objetos completos (valida pertencimento e limite)
        $data['powers'] = $this->service->resolveInitialPowers(
            (int) $data['class_id'],
            $data['powers'] ?? []
        );

        $character = Character::query()->create($data);

        // Registra os níveis por classe (multiclasse ou classe única).
        $this->syncClassLevels($character, $multiclass, (int) $data['class_id'], (int) $data['level']);

        return response()->json(
            $character->load(['race', 'characterClass', 'origin', 'classes', 'deityRelation']),
            201
        );
    }

    public function show(int $id): JsonResponse
    {
        $character = Character::query()
            ->with(['race', 'characterClass', 'origin', 'classes', 'deityRelation'])
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

        $multiclass = $data['classes'] ?? null;

        if (!empty($multiclass)) {
            $resources = $this->service->calculateMulticlassResources($multiclass, (int) $data['constitution']);
            $data['level']    = $resources['total_level'];
            $data['class_id'] = (int) $multiclass[0]['class_id'];
        } else {
            $resources = $this->service->calculateResources(
                (int) $data['class_id'],
                (int) ($data['level'] ?? $character->level ?? 1),
                (int) $data['constitution']
            );
        }

        $data['max_hp'] = $resources['max_hp'];
        $data['max_mp'] = $resources['max_mp'];

        $character->update($data);

        $this->syncClassLevels($character, $multiclass, (int) $data['class_id'], (int) $data['level']);

        return response()->json($character->load(['race', 'characterClass', 'origin', 'classes', 'deityRelation']));
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
            'weapons'                       => 'sometimes|array',
            'weapons.*.name'                => 'required|string|max:120',
            'weapons.*.catalog_id'          => 'nullable|integer|exists:weapons_catalog,id',
            'weapons.*.category'            => 'nullable|in:melee,ranged',
            'weapons.*.attack_attribute'    => 'nullable|in:strength,dexterity',
            'weapons.*.damage_dice'         => ['nullable', 'string', 'regex:/^\d+d\d+$/'],
            'weapons.*.damage_type'         => 'nullable|string|max:40',
            'weapons.*.threat_range'        => 'nullable|integer|min:2|max:20',
            'weapons.*.crit_multiplier'     => 'nullable|integer|min:2|max:4',
            'weapons.*.range'               => 'nullable|string|max:40',
            'weapons.*.attack_bonus'        => 'nullable|integer|min:-20|max:20',
            'weapons.*.damage_bonus'        => 'nullable|integer|min:-20|max:20',
            'weapons.*.add_strength_damage' => 'nullable|boolean',
            'weapons.*.two_handed'          => 'nullable|boolean',
            'weapons.*.proficient'          => 'nullable|boolean',
            'weapons.*.properties'          => 'nullable|array',
            'temp_attack_modifier'          => 'sometimes|integer|min:-20|max:20',
            'temp_damage_modifier'          => 'sometimes|integer|min:-20|max:20',
            'extra_attacks'                 => 'sometimes|integer|min:0|max:10',
            'equipment'                     => 'sometimes|array',
            'equipment.*.name'              => 'required|string|max:120',
            'equipment.*.item_id'           => 'nullable|integer|exists:items_catalog,id',
            'equipment.*.type'              => 'nullable|string|max:40',
            'equipment.*.subtype'           => 'nullable|string|max:40',
            'equipment.*.quantity'          => 'nullable|integer|min:1|max:9999',
            'equipment.*.spaces'            => 'nullable|numeric|min:0|max:99',
            'equipment.*.price'             => 'nullable|integer|min:0',
            'equipment.*.equipped'          => 'nullable|boolean',
            'equipment.*.description'       => 'nullable|string|max:1000',
            'spells'        => 'sometimes|array',
            'powers'        => 'sometimes|array',
            'avatar_url'    => 'sometimes|nullable|url|max:500',
        ]);

        $character->update($validated);

        return response()->json($character->load(['race', 'characterClass', 'origin']));
    }

    public function levelUpPreview(int $id): JsonResponse
    {
        $character = Character::query()
            ->with(['race', 'characterClass', 'origin'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $preview = $this->levelUpService->preview($character);

        return response()->json($preview);
    }

    public function levelUp(LevelUpRequest $request, int $id): JsonResponse
    {
        $character = Character::query()
            ->with(['race', 'characterClass', 'origin'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $character = $this->levelUpService->apply($character, $request->validated());

        return response()->json($character);
    }

    /**
     * Sincroniza os níveis por classe na tabela pivot.
     *
     * @param array<int, array{class_id:int, level:int}>|null $multiclass
     */
    private function syncClassLevels(Character $character, ?array $multiclass, int $primaryClassId, int $level): void
    {
        $pivot = [];

        if (!empty($multiclass)) {
            foreach ($multiclass as $entry) {
                $pivot[(int) $entry['class_id']] = ['level' => max(1, (int) $entry['level'])];
            }
        } else {
            $pivot[$primaryClassId] = ['level' => max(1, $level)];
        }

        $character->classes()->sync($pivot);
    }

    public function destroy(int $id): JsonResponse
    {
        $character = Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $character->delete();

        return response()->json(['message' => 'Personagem removido com sucesso.']);
    }

    /**
     * Atribui (ou remove) a ficha a uma campanha. Só o dono da ficha pode,
     * e apenas para campanhas em que ele participa.
     */
    public function setCampaign(Request $request, int $id): JsonResponse
    {
        $character = Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $data = $request->validate([
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
        ]);

        if (!empty($data['campaign_id'])) {
            $campaign = Campaign::query()->findOrFail($data['campaign_id']);
            if (!$campaign->hasParticipant(auth()->id())) {
                abort(403, 'Você não participa desta campanha.');
            }
            $character->campaign_id = $campaign->id;
        } else {
            $character->campaign_id = null;
        }

        $character->save();

        return response()->json($character->load(['race', 'characterClass', 'origin', 'campaign']));
    }
}

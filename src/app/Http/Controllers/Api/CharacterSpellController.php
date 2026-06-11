<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Spell;
use App\Services\SpellService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterSpellController extends Controller
{
    public function __construct(private readonly SpellService $spellService)
    {
    }

    /**
     * Prévia de conjuração: custo (base + aprimoramentos), CD e alerta de PM
     * sem deduzir os pontos de mana.
     */
    public function preview(Request $request, int $characterId): JsonResponse
    {
        $data = $this->validatePayload($request);
        $character = $this->findCharacter($characterId);
        $spell = Spell::query()->findOrFail($data['spell_id']);

        $cost = $this->spellService->castingCost($spell, $data['enhancements'] ?? []);
        $preview = $this->spellService->castPreview($character, $cost['total']);

        return response()->json([
            'spell'    => $spell->only(['id', 'name', 'circle', 'tradition', 'school']),
            'cost'     => $cost,
            'dc'       => $this->spellService->spellDc($character),
            'mp'       => $preview,
        ]);
    }

    /**
     * Conjura de fato: deduz o PM (bloqueia com alerta se exceder o disponível).
     */
    public function cast(Request $request, int $characterId): JsonResponse
    {
        $data = $this->validatePayload($request);
        $character = $this->findCharacter($characterId);
        $spell = Spell::query()->findOrFail($data['spell_id']);

        $cost = $this->spellService->castingCost($spell, $data['enhancements'] ?? []);
        $result = $this->spellService->cast($character, $cost['total']);

        return response()->json([
            'spell'  => $spell->only(['id', 'name']),
            'cost'   => $cost,
            'result' => $result,
            'character' => $character->fresh(),
        ]);
    }

    /**
     * @return array{spell_id:int, enhancements?:array<int,int>}
     */
    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'spell_id'       => ['required', 'integer', 'exists:spells,id'],
            'enhancements'   => ['nullable', 'array'],
            'enhancements.*' => ['integer', 'min:0'],
        ]);
    }

    private function findCharacter(int $id): Character
    {
        return Character::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }
}

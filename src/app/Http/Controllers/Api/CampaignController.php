<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignController extends Controller
{
    /**
     * Campanhas em que o usuário é mestre ou jogador.
     */
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $campaigns = Campaign::query()
            ->where('gm_user_id', $userId)
            ->orWhereHas('members', fn ($q) => $q->where('users.id', $userId))
            ->withCount('characters')
            ->with('gm:id,name')
            ->orderByDesc('id')
            ->get()
            ->map(fn (Campaign $c) => $this->decorate($c, $userId));

        return response()->json($campaigns);
    }

    /**
     * Cria uma campanha (o usuário atual vira o mestre).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'min:2', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $campaign = Campaign::query()->create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'gm_user_id'  => auth()->id(),
        ]);

        return response()->json($this->decorate($campaign->fresh('gm'), auth()->id()), 201);
    }

    /**
     * Detalhes de uma campanha (mestre ou membro).
     */
    public function show(int $id): JsonResponse
    {
        $campaign = Campaign::query()
            ->with(['gm:id,name', 'members:id,name'])
            ->findOrFail($id);

        $this->authorizeParticipant($campaign);

        return response()->json($this->decorate($campaign, auth()->id()));
    }

    /**
     * Entrar numa campanha usando o código de convite.
     */
    public function join(Request $request): JsonResponse
    {
        $data = $request->validate([
            'invite_code' => ['required', 'string', 'max:12'],
        ]);

        $campaign = Campaign::query()
            ->where('invite_code', strtoupper($data['invite_code']))
            ->first();

        if (!$campaign) {
            throw ValidationException::withMessages([
                'invite_code' => 'Código de convite inválido.',
            ]);
        }

        $userId = auth()->id();

        if ($campaign->gm_user_id === $userId) {
            throw ValidationException::withMessages([
                'invite_code' => 'Você já é o mestre desta campanha.',
            ]);
        }

        $campaign->members()->syncWithoutDetaching([$userId]);

        return response()->json($this->decorate($campaign->fresh('gm'), $userId));
    }

    /**
     * Painel do Mestre: todas as fichas da campanha com dados calculados (somente leitura).
     * Restrito ao mestre.
     */
    public function party(int $id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);

        if ($campaign->gm_user_id !== auth()->id()) {
            abort(403, 'Apenas o mestre pode acessar o painel da campanha.');
        }

        $characters = Character::query()
            ->where('campaign_id', $campaign->id)
            ->with(['race', 'characterClass', 'origin', 'classes', 'deityRelation', 'user:id,name'])
            ->orderBy('name')
            ->get();

        return response()->json([
            'campaign'   => $this->decorate($campaign->fresh('gm'), auth()->id()),
            'characters' => $characters,
        ]);
    }

    /**
     * Sai da campanha (membro) ou exclui (mestre).
     */
    public function leave(int $id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);
        $userId = auth()->id();

        if ($campaign->gm_user_id === $userId) {
            $campaign->delete();
            return response()->json(['message' => 'Campanha excluída.']);
        }

        $campaign->members()->detach($userId);
        Character::query()
            ->where('campaign_id', $campaign->id)
            ->where('user_id', $userId)
            ->update(['campaign_id' => null]);

        return response()->json(['message' => 'Você saiu da campanha.']);
    }

    private function authorizeParticipant(Campaign $campaign): void
    {
        if (!$campaign->hasParticipant(auth()->id())) {
            abort(403, 'Você não participa desta campanha.');
        }
    }

    private function decorate(Campaign $campaign, int $userId): array
    {
        $data = $campaign->toArray();
        $data['is_gm'] = $campaign->gm_user_id === $userId;
        // O código de convite só é visível para o mestre.
        if (!$data['is_gm']) {
            unset($data['invite_code']);
        }

        return $data;
    }
}

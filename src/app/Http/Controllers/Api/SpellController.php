<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spell;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpellController extends Controller
{
    /**
     * Banco de magias com filtros por tradição, escola e círculo.
     */
    public function index(Request $request): JsonResponse
    {
        $spells = Spell::query()
            ->when($request->filled('tradition'), function ($q) use ($request) {
                // Magias universais valem para qualquer tradição.
                $t = (string) $request->string('tradition');
                $q->whereIn('tradition', array_unique([$t, 'universal']));
            })
            ->when($request->filled('school'), fn ($q) => $q->where('school', $request->string('school')))
            ->when($request->filled('circle'), fn ($q) => $q->where('circle', $request->integer('circle')))
            ->orderBy('tradition')
            ->orderBy('circle')
            ->orderBy('school')
            ->orderBy('name')
            ->get();

        return response()->json($spells);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Spell::query()->findOrFail($id));
    }
}

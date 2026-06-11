<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Catálogo de itens com filtros por tipo e subtipo.
     */
    public function index(Request $request): JsonResponse
    {
        $items = ItemCatalog::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('subtype'), fn ($q) => $q->where('subtype', $request->string('subtype')))
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return response()->json($items);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(ItemCatalog::query()->findOrFail($id));
    }
}

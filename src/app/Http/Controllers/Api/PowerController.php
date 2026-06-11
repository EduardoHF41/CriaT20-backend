<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Power;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $powers = Power::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->when($request->filled('race_id'), fn ($q) => $q->where('race_id', $request->integer('race_id')))
            ->orderBy('type')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return response()->json($powers);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Power::query()->with('race')->findOrFail($id));
    }
}

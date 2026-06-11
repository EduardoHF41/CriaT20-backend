<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeaponCatalog;
use Illuminate\Http\JsonResponse;

class WeaponController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            WeaponCatalog::query()->orderBy('category')->orderBy('name')->get()
        );
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(WeaponCatalog::query()->findOrFail($id));
    }
}

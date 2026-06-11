<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deity;
use Illuminate\Http\JsonResponse;

class DeityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Deity::query()->orderBy('name')->get());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Deity::query()->findOrFail($id));
    }
}

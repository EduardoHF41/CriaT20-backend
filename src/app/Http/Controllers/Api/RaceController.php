<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Race;
use Illuminate\Http\JsonResponse;

class RaceController extends Controller
{
    public function index(): JsonResponse
    {
        $races = Race::query()->orderBy('name')->get();

        return response()->json($races);
    }

    public function show(int $id): JsonResponse
    {
        $race = Race::query()->findOrFail($id);

        return response()->json($race);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\JsonResponse;

class OriginController extends Controller
{
    public function index(): JsonResponse
    {
        $origins = Origin::query()
            ->with('features')
            ->orderBy('name')
            ->get();

        return response()->json($origins);
    }

    public function show(int $id): JsonResponse
    {
        $origin = Origin::query()->with('features')->findOrFail($id);

        return response()->json($origin);
    }
}

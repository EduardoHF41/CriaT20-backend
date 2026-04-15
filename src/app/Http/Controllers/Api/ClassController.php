<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CharacterClass;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = CharacterClass::query()->orderBy('name')->get();

        return response()->json($classes);
    }

    public function show(int $id): JsonResponse
    {
        $class = CharacterClass::query()->findOrFail($id);

        return response()->json($class);
    }
}

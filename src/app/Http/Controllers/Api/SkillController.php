<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Skill::query()->orderBy('name')->get());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Skill::query()->findOrFail($id));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['nullable', 'string', 'min:2', 'max:100', 'required_without:username'],
            'username' => ['nullable', 'string', 'min:2', 'max:100', 'required_without:name'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'device_name' => ['nullable', 'string', 'max:120'],
        ]);

        $user = User::query()->create([
            'name' => $payload['username'] ?? $payload['name'],
            'email' => $payload['email'],
            'password' => Hash::make($payload['password']),
        ]);

        $token = $user->createToken($payload['device_name'] ?? 'api-token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso.',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:120'],
        ]);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.',
            ], 401);
        }

        $token = $user->createToken($credentials['device_name'] ?? 'api-token')->plainTextToken;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logout realizado com sucesso.',
        ]);
    }
}

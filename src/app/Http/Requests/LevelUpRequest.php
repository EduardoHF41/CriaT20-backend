<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $attrs = 'in:strength,dexterity,constitution,intelligence,wisdom,charisma';

        return [
            'power'               => 'sometimes|nullable|string|max:200',
            'attribute_boost'     => 'sometimes|nullable|array',
            'attribute_boost.primary'   => ['required_with:attribute_boost', $attrs],
            'attribute_boost.secondary' => ['sometimes', 'nullable', $attrs],
            'new_skill'           => 'sometimes|nullable|string|max:100',
            'new_spell'           => 'sometimes|nullable|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'attribute_boost.primary.required_with' => 'Escolha o atributo principal para a melhoria.',
            'attribute_boost.primary.in'             => 'Atributo inválido.',
            'attribute_boost.secondary.in'           => 'Atributo secundário inválido.',
        ];
    }
}

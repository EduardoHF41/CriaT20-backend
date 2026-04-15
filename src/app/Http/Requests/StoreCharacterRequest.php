<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'race_id' => ['required', 'exists:races,id'],
            'class_id' => ['required', 'exists:character_classes,id'],
            'origin_id' => ['required', 'exists:origins,id'],

            'deity' => ['nullable', 'string', 'max:100'],
            'concept' => ['nullable', 'string', 'max:2000'],
            'attribute_method' => ['required', 'in:point_buy,rolled'],

            'strength' => ['required', 'integer', 'min:-2', 'max:4'],
            'dexterity' => ['required', 'integer', 'min:-2', 'max:4'],
            'constitution' => ['required', 'integer', 'min:-2', 'max:4'],
            'intelligence' => ['required', 'integer', 'min:-2', 'max:4'],
            'wisdom' => ['required', 'integer', 'min:-2', 'max:4'],
            'charisma' => ['required', 'integer', 'min:-2', 'max:4'],

            'origin_benefits' => ['nullable', 'array', 'max:2'],
            'origin_benefits.*' => ['string', 'max:120'],
            'trained_skills' => ['nullable', 'array'],
            'trained_skills.*' => ['string', 'max:120'],
            'powers' => ['nullable', 'array'],
            'powers.*' => ['string', 'max:120'],
            'equipment' => ['nullable', 'array'],
            'spells' => ['nullable', 'array'],

            'max_hp' => ['nullable', 'integer', 'min:1'],
            'max_mp' => ['nullable', 'integer', 'min:0'],
            'defense' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:30'],
            'displacement' => ['nullable', 'string', 'max:30'],
        ];
    }
}

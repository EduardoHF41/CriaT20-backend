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
            'nickname' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'string', 'max:40'],
            'age' => ['nullable', 'string', 'max:30'],
            'height' => ['nullable', 'string', 'max:30'],
            'weight' => ['nullable', 'string', 'max:30'],
            'level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'race_id' => ['required', 'exists:races,id'],
            'class_id' => ['required', 'exists:character_classes,id'],
            'origin_id' => ['required', 'exists:origins,id'],

            // Multiclasse: lista opcional de classes com nível por classe.
            // Quando ausente, usa apenas class_id + level (classe única).
            'classes' => ['nullable', 'array', 'min:1', 'max:5'],
            'classes.*.class_id' => ['required_with:classes', 'exists:character_classes,id'],
            'classes.*.level' => ['required_with:classes', 'integer', 'min:1', 'max:20'],

            'deity' => ['nullable', 'string', 'max:100'],
            'deity_id' => ['nullable', 'exists:deities,id'],
            'deity_obligations' => ['nullable', 'array'],
            'deity_obligations.*' => ['string', 'max:255'],
            'concept' => ['nullable', 'string', 'max:2000'],
            'background' => ['nullable', 'string', 'max:5000'],
            'personality_traits' => ['nullable', 'string', 'max:2000'],
            'attribute_method' => ['required', 'in:point_buy,rolled'],

            'strength' => ['required', 'integer', 'min:-2', 'max:4'],
            'dexterity' => ['required', 'integer', 'min:-2', 'max:4'],
            'constitution' => ['required', 'integer', 'min:-2', 'max:4'],
            'intelligence' => ['required', 'integer', 'min:-2', 'max:4'],
            'wisdom' => ['required', 'integer', 'min:-2', 'max:4'],
            'charisma' => ['required', 'integer', 'min:-2', 'max:4'],

            'racial_flex_choices'   => ['nullable', 'array', 'max:3'],
            'racial_flex_choices.*' => ['string', 'in:strength,dexterity,constitution,intelligence,wisdom,charisma'],
            'racial_subtype'        => ['nullable', 'string', 'max:50'],

            'origin_benefits'   => ['nullable', 'array', 'max:2'],
            'origin_benefits.*' => ['string', 'max:120'],
            'trained_skills' => ['nullable', 'array'],
            'trained_skills.*' => ['string', 'max:120'],
            'armor_penalty' => ['nullable', 'integer', 'min:0', 'max:20'],
            'skill_bonuses' => ['nullable', 'array'],
            'skill_bonuses.*' => ['integer', 'min:-20', 'max:20'],
            'chosen_spell_school'    => ['nullable', 'string', 'max:60'],
            'chosen_spell_schools'   => ['nullable', 'array', 'max:8'],
            'chosen_spell_schools.*' => ['string', 'max:60'],
            'powers' => ['nullable', 'array'],
            'powers.*' => ['string', 'max:120'],
            'equipment' => ['nullable', 'array'],
            'equipment.*.name' => ['required', 'string', 'max:120'],
            'equipment.*.item_id' => ['nullable', 'integer', 'exists:items_catalog,id'],
            'equipment.*.type' => ['nullable', 'string', 'max:40'],
            'equipment.*.subtype' => ['nullable', 'string', 'max:40'],
            'equipment.*.quantity' => ['nullable', 'integer', 'min:1', 'max:9999'],
            'equipment.*.spaces' => ['nullable', 'numeric', 'min:0', 'max:99'],
            'equipment.*.price' => ['nullable', 'integer', 'min:0'],
            'equipment.*.equipped' => ['nullable', 'boolean'],
            'equipment.*.description' => ['nullable', 'string', 'max:1000'],
            'spells' => ['nullable', 'array'],

            // Ataques / armas (estrutura validada)
            'weapons' => ['nullable', 'array'],
            'weapons.*.name' => ['required', 'string', 'max:120'],
            'weapons.*.catalog_id' => ['nullable', 'integer', 'exists:weapons_catalog,id'],
            'weapons.*.category' => ['nullable', 'in:melee,ranged'],
            'weapons.*.attack_attribute' => ['nullable', 'in:strength,dexterity'],
            'weapons.*.damage_dice' => ['nullable', 'string', 'regex:/^\d+d\d+$/'],
            'weapons.*.damage_type' => ['nullable', 'string', 'max:40'],
            'weapons.*.threat_range' => ['nullable', 'integer', 'min:2', 'max:20'],
            'weapons.*.crit_multiplier' => ['nullable', 'integer', 'min:2', 'max:4'],
            'weapons.*.range' => ['nullable', 'string', 'max:40'],
            'weapons.*.attack_bonus' => ['nullable', 'integer', 'min:-20', 'max:20'],
            'weapons.*.damage_bonus' => ['nullable', 'integer', 'min:-20', 'max:20'],
            'weapons.*.add_strength_damage' => ['nullable', 'boolean'],
            'weapons.*.two_handed' => ['nullable', 'boolean'],
            'weapons.*.proficient' => ['nullable', 'boolean'],
            'weapons.*.properties' => ['nullable', 'array'],
            'weapons.*.properties.*' => ['string', 'max:40'],

            'temp_attack_modifier' => ['nullable', 'integer', 'min:-20', 'max:20'],
            'temp_damage_modifier' => ['nullable', 'integer', 'min:-20', 'max:20'],
            'extra_attacks' => ['nullable', 'integer', 'min:0', 'max:10'],

            'max_hp' => ['nullable', 'integer', 'min:1'],
            'max_mp' => ['nullable', 'integer', 'min:0'],
            'defense' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:30'],
            'displacement' => ['nullable', 'string', 'max:30'],
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Limpa e repopula as tabelas de referência para evitar duplicatas
        // Usa TRUNCATE CASCADE para limpar tudo incluindo personagens dependentes
        \Illuminate\Support\Facades\DB::statement('TRUNCATE TABLE origin_features, origins, characters, character_classes, races, skills, weapons_catalog, powers, spells, items_catalog RESTART IDENTITY CASCADE');

        $this->call([
            RaceSeeder::class,
            ClassSeeder::class,
            ClassPowersSeeder::class,
            ClassSkillsSeeder::class,
            SkillSeeder::class,
            WeaponCatalogSeeder::class,
            PowerSeeder::class,
            SpellSeeder::class,
            ItemCatalogSeeder::class,
            OriginSeeder::class,
            OriginFeatureSeeder::class,
            DeitySeeder::class,
        ]);
    }
}

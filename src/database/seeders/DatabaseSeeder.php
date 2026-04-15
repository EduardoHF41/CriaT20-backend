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
        \Illuminate\Support\Facades\DB::table('origin_features')->delete();
        \Illuminate\Support\Facades\DB::table('origins')->delete();
        \Illuminate\Support\Facades\DB::table('character_classes')->delete();
        \Illuminate\Support\Facades\DB::table('races')->delete();

        $this->call([
            RaceSeeder::class,
            ClassSeeder::class,
            ClassPowersSeeder::class,
            OriginSeeder::class,
            OriginFeatureSeeder::class,
        ]);
    }
}

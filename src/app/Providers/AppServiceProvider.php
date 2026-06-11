<?php

namespace App\Providers;

use App\Services\AttackService;
use App\Services\InventoryService;
use App\Services\SkillService;
use App\Services\SpellService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Singletons para compartilhar os caches de catálogo (perícias e armas)
        // entre todos os personagens serializados na mesma requisição.
        $this->app->singleton(SkillService::class);
        $this->app->singleton(AttackService::class);
        $this->app->singleton(SpellService::class);
        $this->app->singleton(InventoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

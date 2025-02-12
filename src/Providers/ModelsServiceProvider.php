<?php

namespace Models\Providers;

use Illuminate\Support\ServiceProvider;

class ModelsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/models.php', 'fidu-models'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/models.php' => config_path('fidu-models.php'),
        ], 'fidu-models-config');
    }
}
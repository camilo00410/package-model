<?php

namespace Fidu\Models\Providers;

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
            __DIR__.'/../src/Models/Users' => app_path('Models/Users'),
        ], 'fidu-models-users');
    }
}

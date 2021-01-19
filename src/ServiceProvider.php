<?php

namespace Michelmelo\Michelangelo;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/michelangelo.php' => config_path('michelangelo.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/michelangelo.php',
            'michelangelo'
        );
    }
}

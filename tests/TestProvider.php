<?php

namespace OpenapiGenerator\Tests;

use Illuminate\Support\ServiceProvider;

class TestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/app/config.php' => config_path('openapi-generator.php'),
            ], 'config');
        }

        $this->loadRoutesFrom(__DIR__ . '/app/routes.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/app/config.php', 'openapi-generator');
    }
}

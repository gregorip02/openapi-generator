<?php

namespace OpenapiGenerator;

use Illuminate\Support\ServiceProvider;
use OpenapiGenerator\Commands\OpenapiGeneratorCommand;
use OpenapiGenerator\Commands\OpenapiSchemaCommand;

class OpenapiGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('openapi-generator.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'openapi-generator');

        $this->commands([
            OpenapiGeneratorCommand::class,
            OpenapiSchemaCommand::class
        ]);
    }
}

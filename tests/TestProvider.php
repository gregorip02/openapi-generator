<?php

namespace OpenapiGenerator\Tests;

use OpenapiGenerator\Commands\OpenapiGeneratorCommand;
use OpenapiGenerator\Commands\OpenapiResponseCommand;
use OpenapiGenerator\Commands\OpenapiSchemaCommand;
use OpenapiGenerator\OpenapiGeneratorServiceProvider;

class TestProvider extends OpenapiGeneratorServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        parent::boot();

        $this->loadRoutesFrom(__DIR__ . '/laravel/routes.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/laravel/config.php', 'openapi-generator');

        $this->commands([
            OpenapiGeneratorCommand::class,
            OpenapiSchemaCommand::class,
            OpenapiResponseCommand::class
        ]);
    }
}

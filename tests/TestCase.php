<?php

namespace OpenapiGenerator\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            TestProvider::class
        ];
    }

    /**
     * Get base path.
     *
     * @return string
     */
    protected function getBasePath(): string
    {
        return __DIR__ . '/laravel';
    }
}

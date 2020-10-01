<?php

namespace OpenapiGenerator\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TestProvider::class
        ];
    }
}

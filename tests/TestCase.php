<?php

namespace OpenapiGenerator\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OpenapiGenerator\OpenapiGeneratorServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [OpenapiGeneratorServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

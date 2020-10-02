<?php

namespace OpenapiGenerator\Tests\Src;

use OpenapiGenerator\Tests\TestCase;

final class GeneratorCommandTest extends TestCase
{
    /** @test can handle php artisan openapi:generate */
    public function handle_artisan_openapi_generate_command(): void
    {
        $command = $this->artisan('openapi:generate');

        $command->assertExitCode(0);
    }
}

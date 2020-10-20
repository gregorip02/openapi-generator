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

    /** @test can handle php artisan openapi:schema */
    public function handle_artisan_openapi_schema_command(): void
    {
        $command = $this->artisan('openapi:schema', ['name' => 'PetSchema']);

        $command->assertExitCode(0);
    }

    /** @test can handle php artisan openapi:response */
    public function handle_artisan_openapi_response_command(): void
    {
        $command = $this->artisan('openapi:response', ['name' => 'PetResponse']);

        $command->assertExitCode(0);
    }
}

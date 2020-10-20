<?php

namespace OpenapiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

final class OpenapiSchemaCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'openapi:schema';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Generate OpenAPI schema class.';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Openapi\\Schemas';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__ . '/../../stubs/schema.stub';
    }
}

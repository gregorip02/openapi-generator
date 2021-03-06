<?php

namespace OpenapiGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use OpenapiGenerator\OpenapiGenerator;
use Symfony\Component\Yaml\Yaml;

final class OpenapiGeneratorCommand extends Command
{
    /**
     * Laravel router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Class instance.
     *
     * @param Illuminate\Routing\Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'openapi:generate';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Generate OpenAPI yaml file.';

    /**
     * Hanlde current command.
     *
     * @return void
     */
    public function handle(): void
    {
        $configuration = $this->packageConfig();

        $template = $configuration->get('template');

        $content = OpenapiGenerator::make($template, $this->router);

        $outputpath = $this->putContents($content, $configuration);

        $message = sprintf('Your OpenAPI specification file was generated in %s', $outputpath);

        $this->info($message);
    }

    /**
     * Create the final OpenAPI file and return its path.
     *
     * @param  array $content
     * @param  \Illuminate\Support\Collection $configuration
     * @return string
     */
    protected function putContents(array $content, Collection $configuration): string
    {
        $outputpath = $configuration->get('outputpath');

        # Returns the YAML representation of a value
        $fileContents = function_exists('yaml_emit')
            ? yaml_emit($content, YAML_UTF8_ENCODING)
            : Yaml::dump($content, 2);

        File::replace($outputpath, $fileContents);

        return $outputpath;
    }

    /**
     * Returns a collection with the configuration for the package.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function packageConfig(): Collection
    {
        return collect(
            config('openapi-generator')
        );
    }
}

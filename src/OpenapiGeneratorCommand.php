<?php

namespace OpenapiGenerator;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

final class OpenapiGeneratorCommand extends Command
{
    protected Router $router;

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

        $content = Yaml::dump(OpenapiGenerator::make($template, $this->router));

        $outputpath = $this->putContents($content, $configuration);

        $message = sprintf('Your OpenAPI specification file was generated in %s', $outputpath);

        $this->info($message);
    }

    /**
     * [puttemplates description]
     * @param  string     $content       [description]
     * @param  Collection $configuration [description]
     * @return string
     */
    protected function putContents(string $content, Collection $configuration): string
    {
        $outputpath = $configuration->get('outputpath');

        File::replace($outputpath, $content);

        return $outputpath;
    }

    /**
     * [packageConfig description]
     * @return [type] [description]
     */
    protected function packageConfig(): Collection
    {
        return collect(
            config('openapi-generator')
        );
    }
}

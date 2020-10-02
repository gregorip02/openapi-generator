<?php

namespace OpenapiGenerator;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

final class OpenapiGenerator
{
    /**
     * Base template of OpenAPI.
     *
     * @var array
     */
    protected array $template;

    /**
     * Router instance.
     *
     * @var \Symfony\Component\Routing\Router
     */
    protected Router $router;

    /**
     * Class instance.
     *
     * @param array $template
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(array $template, Router $router)
    {
        $this->template = $template;

        $this->router = $router;
    }

    /**
     * Get the current OpenAPI template.
     *
     * @return array
     */
    public function template(): array
    {
        return $this->template;
    }

    /**
     * Static class instance and builder.
     *
     * @param  array $template
     * @param  \Illuminate\Routing\Router $router
     * @return array
     */
    public static function make(array $template, Router $router): array
    {
        return (new static(...func_get_args()))->contents();
    }

    /**
     * [contents description]
     * @return [type] [description]
     */
    public function contents(): array
    {
        $paths = $this->paths();

        return array_merge($this->template, $paths);
    }

    public function paths(): array
    {
        $routeCollection = $this->router->getRoutes();

        $paths = ['paths' => []];

        /** @var \Illuminate\Routing\Route $route **/
        foreach ($routeCollection->getRoutes() as $route) {
            $method = $this->method($route);

            $builder = $this->createBuilder($route);

            if ($parameters = $this->parameters($route)) {
                $builder->parameters($parameters);
            }

            if (Str::startsWith('/', $route->uri)) {
                $uri = $route->uri;
            } else {
                $uri = '/' . $route->uri;
                $builder->tag($route->uri);
            }

            $paths['paths'][$uri][$method] = $builder->toArray();
        }

        return $paths;
    }

    /**
     * Create a new instance of the Openapi builder.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return \OpenapiGenerator\OpenapiGeneratorBuilder
     */
    public function createBuilder(Route $route): OpenapiBuilder
    {
        return (new OpenapiBuilder($route))
            ->description('Hello world')
            ->response(200, [
                'description' => 'All good!'
            ]);
    }

    /**
     * Get uri parameters
     *
     * @param  \Illuminate\Routing\Route $route
     * @return array
     */
    public function parameters(Route $route): array
    {
        $uri = $route->uri;

        $params = preg_replace('/(\/?(\w+(\/|$))|(\{|\/$))/i', '', $uri);

        return array_filter(explode('}', $params));
    }

    /**
     * Get route method.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return string
     */
    public function method(Route $route): string
    {
        return strtolower($route->methods[0]);
    }
}

<?php

namespace OpenapiGenerator;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use OpenapiGenerator\LaravelControllerReflection;

final class OpenapiGenerator
{
    /**
     * Base template of OpenAPI.
     *
     * @var array
     */
    protected $template;

    /**
     * Laravel router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

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
     * Combine template with route paths.
     *
     * @return array
     */
    public function contents(): array
    {
        $paths = $this->paths();

        return array_merge($this->template, $paths);
    }

    /**
     * Route path generation.
     *
     * @return array
     */
    public function paths(): array
    {
        $routeCollection = $this->router->getRoutes();

        $paths = [];

        /** @var \Illuminate\Routing\Route $route **/
        foreach ($routeCollection->getRoutesByName() as $route) {
            $uri = '/' . Str::of($route->uri)->ltrim('/');

            if ($this->wildcard($uri)) {
                $path = $this->buildPathDefinition($uri, $route);

                $paths[$uri][$this->method($route)] = $path;
            }
        }

        return compact('paths');
    }

    /**
     * Create a path builder.
     *
     * @param  string $uri
     * @param  \Illuminate\Routin\Route $route
     * @return array
     */
    public function buildPathDefinition(string $uri, Route $route): array
    {
        [$controller, $method] = $this->action($route);

        $reflectionController = new LaravelControllerReflection($controller);

        $description = $reflectionController->descriptionFor($method);

        // Assign parameters based on Laravel route definnition.
        $parameters = $this->parameters($uri);

        $path = PathItem::create()
            ->route($uri)
            ->parameters(...$parameters)
            ->description($description)
            ->toArray();

        // Assign a tagname for the uri only if do not starts with /api/*
        // We rely on resource/actions behavior for generic tags names
        if ($tagname = preg_replace('/^\/api\//', '', $uri)) {
            $path['tags'] = [explode('/', $tagname)[0]];
        }

        $responses = $reflectionController->responsesFor($method);

        foreach ($responses as $code => $response) {
            $path['responses'][$code] = $response->toArray();
        }

        return $path;
    }

    protected function action(Route $route): array
    {
        ['controller' => $action] = $route->getAction();

        $action .= '@__invoke';

        return array_slice(explode('@', $action), 0, 2);
    }

    /**
     * Check that the current URI passes the wildcard.
     *
     * @param  string $uri
     * @return boolean
     */
    protected function wildcard(string $uri): bool
    {
        $wildcards = config('openapi-generator.wildcards', []);

        $passess = array_filter(
            $wildcards,
            function ($wildcard) use ($uri) {
                return preg_match($wildcard, $uri);
            }
        );

        return count($passess);
    }

    /**
     * Get uri parameters based on Laravel route definition.
     *
     * @param  string $uri
     * @return array
     */
    public function parameters(string $uri): array
    {
        preg_match_all('/\{[a-zA-Z-_]*\}/i', $uri, $matches);

        $matches = \Illuminate\Support\Arr::flatten($matches);

        return array_map(function ($match) {
            $name =  preg_replace('/\{|\}/i', '', $match);

            return Parameter::path()
                ->name($name)
                ->required()
                ->description("{$name} route name")
                ->schema(Schema::integer());
        }, $matches);
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

<?php

namespace OpenapiGenerator;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use OpenapiGenerator\Agreements\PathDefinition;
// use ReflectionClass;

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

            // We build path definition for wildcards routes.
            if ($this->wildcard($uri)) {
                $path = $this->buildPathDefinition($uri, $route);

                $paths[$path->uri][$path->method] = $path->toArray();
            }
        }

        return compact('paths');
    }

    /**
     * Create a path builder.
     *
     * @param  string $uri
     * @param  \Illuminate\Routin\Route $route
     * @return \OpenapiGenerator\Agreements\PathDefinition
     */
    public function buildPathDefinition(string $uri, Route $route): PathDefinition
    {
        $builder = $this->pathBuilder($route);

        // Assign parameters based on Laravel route definnition.
        if ($parameters = $this->parameters($uri)) {
            $builder->parameters($parameters);
        }

        // Assign a tagname for the uri only if do not starts with /api/*
        // We rely on resource/actions behavior for generic tags names
        if ($tagname = preg_replace('/^\/api\//', '', $uri)) {
            $builder->tagname($tagname);
        }

        return new PathDefinition($uri, $this->method($route), $builder);
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
    public function response(OpenapiPathBuilder &$builder, Route $route): void
    {
        if ($route->getActionName() == 'Closure') {
            return;
        }

        $method = $route->getActionMethod();

        $controller = $route->getController();

        if (method_exists($controller, $method)) {
            $ctlReflection = (new ReflectionClass($controller))->getMethod($method);

            if ($classname = optional($ctlReflection->getReturnType())->getName()) {
                $resReflection = new ReflectionClass($classname);

                if (Str::endsWith($resReflection->getName(), 'Collection')) {
                    $defaultCollectionProperties = $resReflection->getDefaultProperties();

                    if (class_exists($defaultCollectionProperties['collects'])) {
                        $resReflection = new ReflectionClass(
                            $defaultCollectionProperties['collects']
                        );
                    }
                }
            }
        }
    } **/

    /**
     * Create a new instance of the Openapi path builder.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return \OpenapiGenerator\OpenapiGeneratorBuilder
     */
    public function pathBuilder(Route $route): OpenapiPathBuilder
    {
        return (new OpenapiPathBuilder($route))
            ->response(200, [
                'description' => 'Work in progress'
            ]);
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

        return array_map(
            function ($match) {
                return preg_replace('/\{|\}/i', '', $match);
            },
            $matches
        );
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

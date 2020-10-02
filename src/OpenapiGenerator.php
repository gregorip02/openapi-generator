<?php

namespace OpenapiGenerator;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
// use ReflectionClass;

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

        $paths = ['paths' => []];

        /** @var \Illuminate\Routing\Route $route **/
        foreach ($routeCollection->getRoutesByName() as $route) {
            if ($this->wildcard($route->uri)) {
                $method = $this->method($route);

                $builder = $this->createBuilder($route);

                $uri = '/' . Str::of($route->uri)->ltrim('/');

                if ($parameters = $this->parameters($uri)) {
                    $builder->parameters($parameters);
                }

                if ($tagname = preg_replace('/^\/api\//', '', $uri)) {
                    $builder->tag($tagname);
                }

                $paths['paths'][$uri][$method] = $builder->toArray();
            }
        }

        return $paths;
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
            fn ($wildcard) => preg_match($wildcard, $uri)
        );

        return count($passess);
    }

    /**
    public function response(OpenapiBuilder &$builder, Route $route): void
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
                'description' => 'Work in progress'
            ]);
    }

    /**
     * Get uri parameters
     *
     * @param  string $uri
     * @return array
     */
    public function parameters(string $uri): array
    {
        preg_match_all('/\{[a-zA-Z-]*\}/i', $uri, $matches);

        $matches = \Illuminate\Support\Arr::flatten($matches);

        return array_map(
            fn ($match) => preg_replace('/\{|\}/i', '', $match),
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

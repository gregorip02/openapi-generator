<?php

namespace OpenapiGenerator;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;

final class OpenapiBuilder
{
    /**
     * Builder collection attributes.
     *
     * @var Collection
     */
    protected Collection $attributes;

    /**
     * Route instance.
     *
     * @var \Illuminate\Routing\Route
     */
    protected Route $route;

    /**
     * Class instance.
     *
     * @param array $attributes
     */
    public function __construct(Route $route, array $attributes = [])
    {
        $this->route = $route;

        $this->attributes = Collection::make($attributes);
    }

    /**
     * Add description tag.
     *
     * @param  string $description
     * @return $this
     */
    public function description(string $description): OpenapiBuilder
    {
        return $this->put('description', $description);
    }

    /**
     * Add tag name.
     *
     * @param  string $tag
     * @return $this
     */
    public function tag(string $tag): OpenapiBuilder
    {
        $tags = $this->attributes->get('tags', []);

        $tags[] = strtolower(explode('/', $tag)[0]);

        return $this->put('tags', $tags);
    }

    /**
     * Add response tag.
     *
     * @param  int $code
     * @param  array $attributes
     * @return $this
     */
    public function response(int $code, array $attributes): OpenapiBuilder
    {
        $responses = $this->attributes->get('responses', []);

        $responses[$code] = $attributes;

        return $this->put('responses', $responses);
    }

    /**
     * Add values to builder.
     *
     * @param string $key
     * @param mixed $data
     * @return $this
     */
    public function put(string $key, $data): OpenapiBuilder
    {
        $this->attributes->put($key, $data);

        return $this;
    }

    /**
     * Add operations can have parameters passed via URL path.
     *
     * @param  array  $parameters
     * @return $this
     */
    public function parameters(array $parameters): OpenapiBuilder
    {
        $builderParameters = $this->attributes->get('parameters', []);

        $builderParameterNames = array_filter($builderParameters, function ($parameterDefinition) {
            return $parameterDefinition['name'];
        });

        foreach ($parameters as $parameter) {
            if (! in_array($parameter, $builderParameterNames)) {
                $builderParameters[] = [
                    'description' => 'Hello world',
                    'name' => $parameter,
                    'required' => true,
                    'in' => 'path',
                    'schema' => [
                        'type' => 'integer'
                    ]
                ];
            }
        }

        return $this->put('parameters', $builderParameters);
    }

    /**
     * Returns attributes array representation.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes->toArray();
    }
}

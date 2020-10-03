<?php

namespace OpenapiGenerator;

use Illuminate\Support\Collection;

final class OpenapiPathBuilder
{
    /**
     * Builder collection attributes.
     *
     * @var Collection
     */
    protected Collection $attributes;

    /**
     * Class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = Collection::make($attributes);
    }

    /**
     * Add description tag.
     *
     * @param  string $description
     * @return $this
     */
    public function description(string $description): OpenapiPathBuilder
    {
        return $this->put('description', $description);
    }

    /**
     * Add tagname.
     *
     * @param  string $tagname
     * @return $this
     */
    public function tagname(string $tagname): OpenapiPathBuilder
    {
        $tags = $this->get('tags', []);

        $tagname = strtolower(explode('/', $tagname)[0]);

        if (! in_array($tagname, $tags)) {
            $tags[] = $tagname;
        }

        return $this->put('tags', $tags);
    }

    /**
     * Add response tag.
     *
     * @param  int $code
     * @param  array $attributes
     * @return $this
     */
    public function response(int $code, array $attributes): OpenapiPathBuilder
    {
        $responses = $this->get('responses', []);

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
    public function put(string $key, $data): OpenapiPathBuilder
    {
        $this->attributes->put($key, $data);

        return $this;
    }

    /**
     * Get an item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->attributes->get($key, $default);
    }

    /**
     * Add operations can have parameters passed via URL path.
     *
     * @param  array  $parameters
     * @return $this
     */
    public function parameters(array $parameters): OpenapiPathBuilder
    {
        $builderParameters = $this->get('parameters', []);

        $builderParameterNames = array_filter($builderParameters, function ($parameterDefinition) {
            return $parameterDefinition['name'];
        });

        /** @var string $parameter */
        foreach ($parameters as $parameter) {
            if (! in_array($parameter, $builderParameterNames)) {
                $builderParameters[] = [
                    'description' => sprintf('%s identifier', $parameter),
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

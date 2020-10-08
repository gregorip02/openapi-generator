<?php

namespace OpenapiGenerator\Agreements;

use Illuminate\Contracts\Support\Arrayable;
use OpenapiGenerator\OpenapiPathBuilder;

final class PathDefinition implements Arrayable
{
    public $uri;

    public $method;

    public OpenapiPathBuilder $builder;

    public function __construct(string $uri, string $method, OpenapiPathBuilder $builder)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->builder = $builder;
    }

    /**
     * Generate array representation of the path definition.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->builder->toArray();
    }
}

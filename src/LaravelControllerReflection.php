<?php

namespace OpenapiGenerator;

use ReflectionClass;
use Illuminate\Support\Arr;

final class LaravelControllerReflection
{
    /**
     * Reflection controller instance.
     *
     * @var ReflectionClass
     */
    public ReflectionClass $controller;

    /**
     * Class instance.
     *
     * @param string $controller
     */
    public function __construct(string $controller)
    {
        $this->controller = new ReflectionClass($controller);
    }

    /**
     * Returns a description based on PHPDocs of the especified method name.
     *
     * @param  string $methodName
     * @return string
     */
    public function descriptionFor(string $methodName): string
    {
        $default = 'Please provide PHPDocs for this path.';
        
        if (! $this->controller->hasMethod($methodName)) {
            return $default;
        }

        $method = $this->controller->getMethod($methodName);

        $comment = preg_replace('/\/|\*|\*|\\n/', '', $method->getDocComment());

        $explode = explode('@', $comment);

        return trim(Arr::first($explode, null, $default));
    }
}

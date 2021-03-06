<?php

namespace OpenapiGenerator;

use ReflectionClass;
use ReflectionNamedType;
use Illuminate\Support\Arr;
use OpenapiGenerator\Agreements\OpenapiDocument;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;

final class LaravelControllerReflection
{
    /**
     * Reflection controller instance.
     *
     * @var \ReflectionClass
     */
    public $controller;

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

    /**
     * [returnTypeFor description]
     * @param  string $methodName [description]
     * @return array
     */
    public function responsesFor(string $methodName): array
    {
        $default = [
            '200' => Response::ok()->description('Please provide response type')
        ];

        if (! $this->controller->hasMethod($methodName)) {
            return $default;
        }

        $method = $this->controller->getMethod($methodName);

        $return = $method->getReturnType();

        if ($return instanceof ReflectionNamedType) {
            $responseClassName = $return->getName();

            if (class_exists($responseClassName)) {
                $response = new ReflectionClass($responseClassName);

                if ($response->implementsInterface(OpenapiDocument::class)) {
                    return call_user_func([$responseClassName, 'document']);
                }
            }
        }

        return $default;
    }
}

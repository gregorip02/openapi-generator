<?php

namespace OpenapiGenerator\Agreements;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;

abstract class ResponseDefinition
{
    abstract public static function response(): Response;

    public function toArray(): array
    {
        return (new static)->response()->toArray();
    }
}

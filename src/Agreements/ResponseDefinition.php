<?php

namespace OpenapiGenerator\Agreements;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;

abstract class ResponseDefinition
{
    abstract public static function response(): Response;

    abstract public function toArray(): array;
}

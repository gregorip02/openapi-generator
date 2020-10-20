<?php

namespace OpenapiGenerator\Agreements;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;

abstract class SchemaDefinition
{
    abstract public function properties(): SchemaContract;
}

<?php

namespace OpenapiGenerator\Agreements;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

abstract class SchemaDefinition
{
    abstract public function properties(): SchemaContract;
}

<?php

namespace OpenapiGenerator\Tests\App\Openapi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use OpenapiGenerator\Agreements\SchemaDefinition;

class PetListSchema extends SchemaDefinition
{
    public function properties(): SchemaContract
    {
        $items = (new PetSchema)->properties();

        return Schema::array()->items($items);
    }
}

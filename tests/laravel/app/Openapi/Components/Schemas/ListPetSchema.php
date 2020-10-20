<?php

namespace OpenapiGenerator\Tests\App\Openapi\Components\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use OpenapiGenerator\Agreements\SchemaDefinition;

class ListPetSchema extends SchemaDefinition
{
    public function properties(): SchemaContract
    {
        $items = (new PetSchema)->properties();

        return Schema::array()->items($items);
    }
}

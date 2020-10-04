<?php

namespace OpenapiGenerator\Tests\App\Openapi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use OpenapiGenerator\Agreements\SchemaDefinition;

class PetSchema extends SchemaDefinition
{
    public function properties(): SchemaContract
    {
        return Schema::object('Pet')
           ->required('id', 'name')
           ->properties(
               Schema::integer('id')->format(Schema::FORMAT_INT32),
               Schema::string('name'),
           );
    }
}

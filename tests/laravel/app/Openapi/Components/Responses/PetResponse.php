<?php

namespace OpenapiGenerator\Tests\App\Openapi\Components\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use OpenapiGenerator\Agreements\ResponseDefinition;
use OpenapiGenerator\Tests\App\Openapi\Components\Schemas\ListPetSchema;

final class PetResponse extends ResponseDefinition
{
    public static function response(): Response
    {
        //
    }

    public function toArray(): array
    {
        return (new static)->response()->toArray();
    }
}

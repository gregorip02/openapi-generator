<?php

namespace OpenapiGenerator\Tests\App\Openapi\Components\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use OpenapiGenerator\Agreements\ResponseDefinition;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use OpenapiGenerator\Tests\App\Openapi\Components\Schemas\ListPetSchema;

final class PetListResponse extends ResponseDefinition
{
    public static function response(): Response
    {
        $content = MediaType::json()->schema(
            (new ListPetSchema)->properties()
        );

        return Response::ok()->content($content);
    }

    public function toArray(): array
    {
        return (new static)->response()->toArray();
    }
}

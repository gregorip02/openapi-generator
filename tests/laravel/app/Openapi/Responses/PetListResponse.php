<?php

namespace OpenapiGenerator\Tests\App\Openapi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use OpenapiGenerator\Agreements\ResponseDefinition;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use OpenapiGenerator\Tests\App\Openapi\Schemas\PetListSchema;

final class PetListResponse extends ResponseDefinition
{
    public static function response(): Response
    {
        $content = MediaType::json()->schema(
            (new PetListSchema)->properties()
        );

        return Response::ok()->content($content);
    }
}

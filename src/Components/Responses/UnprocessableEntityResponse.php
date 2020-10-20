<?php

namespace OpenapiGenerator\Components\Responses;

use OpenapiGenerator\Agreements\ResponseDefinition;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;

final class UnprocessableEntityResponse extends ResponseDefinition
{
    public static function response(): Response
    {
        return Response::unprocessableEntity();
    }
}

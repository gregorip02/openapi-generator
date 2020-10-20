<?php

namespace OpenapiGenerator\Agreements;

interface OpenapiDocument
{
    /**
     * Build response documents.
     *
     * @return \GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract[]
     */
    public static function document(): array;
}

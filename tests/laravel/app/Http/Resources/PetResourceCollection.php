<?php

namespace OpenapiGenerator\Tests\App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenapiGenerator\Agreements\OpenapiDocument;
use OpenapiGenerator\Components\Responses\UnprocessableEntityResponse;
use OpenapiGenerator\Tests\App\Openapi\Responses\PetListResponse;

final class PetResourceCollection extends ResourceCollection implements OpenapiDocument
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = PetResource::class;

    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }

    public static function document(): array
    {
        return [
            '200' => new PetListResponse,
            '422' => new UnprocessableEntityResponse
        ];
    }
}

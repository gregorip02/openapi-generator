<?php

namespace OpenapiGenerator\Tests\App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class PetResourceCollection extends ResourceCollection
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
}

<?php

namespace OpenapiGenerator\Tests\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenapiGenerator\Agreements\OpenapiDocument;

final class PetResource extends JsonResource implements OpenapiDocument
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => rand(1, 1000),
            'age' => 3,
            'name' => 'Little pet',
        ];
    }

    public static function document(): array
    {
        return [];
    }
}

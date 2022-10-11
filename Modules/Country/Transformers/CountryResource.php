<?php

namespace Modules\Country\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="CountryResource",
 *      description="Country resource",
 * )
 */
class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @OA\Property(property="name", type="string", ),
     * @OA\Property(property="key", type="string", ),
     *
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

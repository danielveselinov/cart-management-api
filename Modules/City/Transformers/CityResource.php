<?php

namespace Modules\City\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *      title="CityResource",
 *      description="City resource",
 * )
 */
class CityResource extends JsonResource
{
    /**
     * @OA\Property(property="name", type="string", ),
     * @OA\Property(property="country_id", type="integer", ),
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

<?php

namespace Modules\Address\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="AddressResource",
 *      description="Address resource",
 * )
 */
class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @OA\Property(property="user_id", type="integer", ),
     * @OA\Property(property="country_id", type="integer", ),
     * @OA\Property(property="city_id", type="integer", ),
     * @OA\Property(property="area", type="string", ),
     * @OA\Property(property="street", type="string", ),
     * @OA\Property(property="building", type="string", ),
     * @OA\Property(property="apartment", type="integer", ),
     * @OA\Property(property="landmark", type="string", ),
     * @OA\Property(property="is_main", type="boolean", ),
     * 
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

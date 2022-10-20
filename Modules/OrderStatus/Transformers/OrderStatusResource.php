<?php

namespace Modules\OrderStatus\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="OrderStatusResource",
 *      description="Order status resource",
 * )
 */
class OrderStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id", type="integer", ),
     * @OA\Property(property="status", type="string", ),
     * 
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

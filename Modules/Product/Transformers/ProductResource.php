<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="ProductResource",
 *      description="Product resource",
 * )
 */
class ProductResource extends JsonResource
{
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     * 
     * @OA\Property(property="id", type="integer", ),
     * @OA\Property(property="category_id", type="integer", ),
     * @OA\Property(property="name", type="string", ),
     * @OA\Property(property="description", type="string", ),
     * @OA\Property(property="old_price", type="float", ),
     * @OA\Property(property="final_price", type="float", ),
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

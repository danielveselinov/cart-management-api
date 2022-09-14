<?php

namespace Modules\Category\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="CategoryResource",
 *      description="Category resource",
 * )
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @OA\Property(property="id", type="integer", ),
     * @OA\Property(property="name", type="string", ),
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

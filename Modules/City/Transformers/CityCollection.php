<?php

namespace Modules\City\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *      title="CityCollection",
 *      description="City collection"
 * ),
 */

class CityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @OA\Property(
     *      property="cities",
    *       description="City Collection",
    *       type="array",
    *       @OA\Items(
    *           ref="#/components/schemas/CityResource"
    *       )
     * ),
     * @OA\Property(
     *      property="pagination",
     *      type="object",
     *      @OA\Property(property="total", type="integer", ),
     *      @OA\Property(property="count", type="integer", ),
     *      @OA\Property(property="per_page", type="integer", ),
     *      @OA\Property(property="current_page", type="integer", ),
     *      @OA\Property(property="total_page", type="integer")
     * )
     * 
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}

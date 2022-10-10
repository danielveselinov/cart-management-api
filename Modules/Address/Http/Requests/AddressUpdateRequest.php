<?php

namespace Modules\Address\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="AddressUpdateRequest",
 *      description="Update address request body data",
 *      type="object",
 *      required={"country_id", "city_id", "area", "street", "building", "apartment", "landmark", "is_main"}
 * )
 */
class AddressUpdateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      property="country_id",
     *      title="Country ID",
     *      description="ID of the Country",
     *      example="1"
     * ),
     * @OA\Property(
     *      property="city_id",
     *      title="City ID",
     *      description="ID of the City",
     *      example="1"
     * ),
     * @OA\Property(
     *      property="area",
     *      title="Area",
     *      description="Area",
     *      example="Downtown"
     * ),
     * @OA\Property(
     *      property="street",
     *      title="Street",
     *      description="Street",
     *      example="Street Eineberg no.24"
     * ),
     * @OA\Property(
     *      property="building",
     *      title="Bulding",
     *      description="Building",
     *      example="biggest one on the left, gray"
     * ),@OA\Property(
     *      property="apratment",
     *      title="Apartment No.",
     *      description="Apartment number",
     *      example="1"
     * ),
     * @OA\Property(
     *      property="landmark",
     *      title="Landmark",
     *      description="Landmark",
     *      example="Landmark here."
     * ),
     * @OA\Property(
     *      property="is_main",
     *      title="Is main?",
     *      description="If is your main address? (1 = true / 0 = false)",
     *      example="1"
     * ),
     */
    public function rules()
    {
        return [
            'country_id' => 'required',
            'city_id' => 'required',
            'area' => 'required|string',
            'street' => 'required|string',
            'building' => 'required|string',
            'apartment' => 'required|integer',
            'landmark' => 'required',
            'is_main' => 'required|boolean'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

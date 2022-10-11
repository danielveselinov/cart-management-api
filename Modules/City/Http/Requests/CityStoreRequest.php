<?php

namespace Modules\City\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *      title="CityStoreRequest",
 *      description="Create city request body data",
 *      type="object",
 *      required={"name", "country_id"}
 * )
 */
class CityStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @OA\Property(
     *      property="name",
     *      title="City name",
     *      description="Name of the city",
     *      example="Shtip"
     * ),
     * @OA\Property(
     *      property="country_id",
     *      title="Country ID",
     *      description="ID of the country",
     *      example="1"
     * ),
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'country_id' => 'required'
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

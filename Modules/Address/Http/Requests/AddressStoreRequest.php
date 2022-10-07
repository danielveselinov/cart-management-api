<?php

namespace Modules\Address\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
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

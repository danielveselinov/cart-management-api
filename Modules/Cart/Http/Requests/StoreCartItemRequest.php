<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="StoreCartItemRequest",
 *      description="Cart Item store request",
 *      type="object",
 *      required={"product_id", "qty"}
 * )
 */
class StoreCartItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     * @OA\Property(
     *      property="product_id",
     *      title="Product id",
     *      description="Enter product id",
     * ),
     * @OA\Property(
     *      property="qty",
     *      title="Quantity",
     *      description="Enter quantity",
     * ),
     * 
     */
    public function rules()
    {
        return [
            'product_id' => 'required',
            'qty' => 'required|integer',
            'payment_type_id' => 'required|integer'
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

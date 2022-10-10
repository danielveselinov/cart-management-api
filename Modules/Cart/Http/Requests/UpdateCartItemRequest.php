<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="UpdateCartItemRequest",
 *      description="Cart Item update request",
 *      type="object",
 *      required={"cart_id", "product_id", "qty"}
 * )
 */
class UpdateCartItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     * @OA\Property(
     *      property="cart_id",
     *      title="Cart id",
     *      example="1",
     *      description="Enter cart id",
     * ),
     * @OA\Property(
     *      property="product_id",
     *      title="Product id",
     *      example="1",
     *      description="Enter product id",
     * ),
     * @OA\Property(
     *      property="qty",
     *      title="Quantity",
     *      example="1",
     *      description="Enter quantity",
     * ),
     */
    public function rules()
    {
        return [
            'cart_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required|integer'
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

<?php

namespace Modules\OrderStatus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="UpdateOrderStatusRequest",
 *      description="Order status update request",
 *      type="object",
 *      required={"order_id", "order_status_id"}
 * )
 */
class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(
     *      property="order_status_id",
     *      title="Order Status id",
     *      example="1",
     *      description="Enter order status id",
     * ),
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'order_status_id' => 'required'
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

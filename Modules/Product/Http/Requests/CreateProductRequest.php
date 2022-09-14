<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="CreateProductRequest",
 *      description="Create Product request body data",
 *      type="object",
 *      required={"category_id", "name", "description", "final_price"},
 *      nullable={"old_price"}
 * )
 */
class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @OA\Property(
     *      property="category_id",
     *      title="Product Category ID",
     *      description="ID of the category",
     *      example="lorem"
     * ),
     * @OA\Property(
     *      property="name", 
     *      title="Product name", 
     *      description="Name of the product", 
     *      example="Lorem Ipsum Dolor"
     * ),
     * @OA\Property(
     *      property="description", 
     *      title="Description", 
     *      description="Description of the product",
     *      example="Lorem ipsum dolor sit amet, consectetur adipiscing elit.."
     * ),
     * @OA\Property(
     *      property="old_price",
     *      title="Old price",
     *      description="Old price of the product",
     *      example="999.99",
     * ),
     * @OA\Property(
     *      property="final_price",
     *      title="Final price",
     *      description="Final price of the product",
     *      example="1120",
     * ),
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required',
            'old_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'final_price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
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

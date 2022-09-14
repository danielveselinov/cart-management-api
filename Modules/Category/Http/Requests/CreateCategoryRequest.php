<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="CreateCategoryRequest",
 *      description="Create Category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class CreateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @OA\Property(
     *      property="name",
     *      title="Category name",
     *      description="Name of the category",
     *      example="lorem"
     * ),
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string'
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

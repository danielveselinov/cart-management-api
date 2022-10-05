<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CreateCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Transformers\CategoryResource;
use Modules\Product\Transformers\ProductCollection;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/category",
     *      operationId="getCategoriesList",
     *      tags={"Categories"},
     *      summary="Get list of categories",
     *      description="Returns list of categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return response()->json(new ProductCollection(Category::paginate()), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/category",
     *      operationId="storeCategory",
     *      tags={"Categories"},
     *      summary="Store new category",
     *      description="Returns category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create(['name' => $request->name]);

        return response()->json(new CategoryResource($category), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/category/{id}",
     *      operationId="getCategoryById",
     *      tags={"Categories"},
     *      summary="Get category information",
     *      description="Returns category data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/category/{id}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      summary="Update existing category",
     *      description="Returns updated category data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update(['name' => $request->name]);

        return response()->json(new CategoryResource($category), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/category/{id}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      summary="Delete existing category",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Category $category)
    {
        $category->products()->delete();
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/category/{id}/force",
     *      operationId="forceDeleteCategory",
     *      tags={"Categories"},
     *      summary="Force delete existing category",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function delete(Category $category)
    {
        $category->products()->forceDelete();
        $category->forceDelete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/category/{category}/restore",
     *      operationId="restoreCategory",
     *      tags={"Categories"},
     *      summary="Restore new category",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function restore($category)
    {   
        Category::where('id', $category)->withTrashed()->restore();

        return response()->json(['message' => 'Category restored!'], Response::HTTP_OK);
    }
}

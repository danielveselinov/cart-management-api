<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Transformers\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return new ProductResource(Product::with('category')->get());
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateProductRequest $request
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'old_price' => $request->old_price,
            'final_price' => $request->final_price
        ]);

        return response()->json(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Show the specified resource.
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'old_price' => $request->old_price,
            'final_price' => $request->final_price
        ]);

        return response()->json(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

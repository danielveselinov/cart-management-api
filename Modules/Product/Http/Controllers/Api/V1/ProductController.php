<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Transformers\ProductResource;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;

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

    /**
     * Filter the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function filter(Request $request)
    {
        $query = Product::with(['category']);
        
        if ($request->product) {
            $query->where('name', 'LIKE', '%' . $request->product . '%');
        }

        if ($request->category) {
            $query->WhereHas('category', function($query) use($request) {
                $query->where('name', 'LIKE', '%' . $request->category . '%');
            });
        }
        
        $products = $query->get();

        return response()->json(new ProductResource($products), Response::HTTP_ACCEPTED);
    }
}

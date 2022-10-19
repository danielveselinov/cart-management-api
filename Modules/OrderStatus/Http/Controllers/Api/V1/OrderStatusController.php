<?php

namespace Modules\OrderStatus\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\OrderStatus\Entities\OrderStatus;
use Modules\OrderStatus\Transformers\OrderStatusResource;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(new OrderStatusResource(OrderStatus::all()), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}

<?php

namespace Modules\OrderStatus\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cart\Entities\Order;
use Modules\OrderStatus\Entities\OrderStatus;
use Modules\OrderStatus\Http\Requests\UpdateOrderStatusRequest;
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
     * @param Order $order
     * @return Response
     */
    public function update(UpdateOrderStatusRequest $request, Order $order)
    {
        $updated = $order->update(['order_status_id' => $request->order_status_id]);

        if (!$updated) {
            return response()->json(['message' => 'There was an error while updating order status.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => 'Order status updated.'], Response::HTTP_OK);
    }
}

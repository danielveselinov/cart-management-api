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
     * 
     * @OA\Get(
     *      path="/api/v1/order-statuses",
     *      operationId="getOrderStatusesList",
     *      tags={"OrderStatuses"},
     *      summary="Get list of order statuses",
     *      description="Returns list of order statuses",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/OrderStatusResource")
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
        return response()->json(new OrderStatusResource(OrderStatus::all()), Response::HTTP_OK);
    }

    /**
     @OA\Put(
     *      path="/api/v1/update-order-status/{order}",
     *      operationId="updateOrderStatus",
     *      tags={"OrderStatuses"},
     *      summary="Update existing order status",
     *      description="Update existing order status",
     *      @OA\Parameter(
     *          name="order_id",
     *          description="Order id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="order_status_id",
     *          description="Order Status id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateOrderStatusRequest")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Order status updated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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

<?php

namespace Modules\Cart\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Entities\Address;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Entities\CartItems;
use Modules\Cart\Entities\Order;
use Modules\Cart\Entities\OrderItems;
use Modules\Cart\Events\OrderPlaced;
use Modules\Cart\Http\Requests\StoreCartItemRequest;
use Modules\Cart\Http\Requests\UpdateCartItemRequest;
use Modules\PaymentType\Entities\PaymentType;
use Modules\Product\Entities\Product;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     * 
     * @OA\Post(
     *      path="/api/v1/cart-item",
     *      operationId="cart",
     *      tags={"Cart"},
     *      summary="Create a cart",
     *      description="Create a cart for logged in user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCartItemRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="New cart is being created",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     */
    public function store(StoreCartItemRequest $request)
    {
        $address = Address::where('user_id', Auth::id())
                ->where('is_main', 1)
                ->first();
        
        // address_id is set just to 1 for testing prurposes .. still
        $cart = Cart::firstOrCreate(['user_id' => Auth::id(), 'address_id' => 1, 'payment_type_id' => $request->payment_type_id]);

        $cartItem = CartItems::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'qty' => $request->qty
        ]);

        return response()->json($cartItem, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Cart $cart
     * @return Response
     * 
     * @OA\Put(
     *      path="/api/v1/cart-item/{cart}",
     *      operationId="updateCartItem",
     *      tags={"Cart"},
     *      summary="Update existing cart",
     *      description="Update existing cart",
     *      @OA\Parameter(
     *          name="product_id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cart_id",
     *          description="Cart id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCartItemRequest")
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
     *          response=202,
     *          description="Cart updated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * 
     */
    public function update(UpdateCartItemRequest $request, Cart $cart)
    {
        $cartItems = CartItems::where('product_id', '=', $request->product_id)
                ->where('cart_id', '=', $cart->id)
                ->first();

        if (!$cartItems) {
            return response()->json(['message' => 'Cart item not found.'], Response::HTTP_NOT_FOUND);
        }
                    
        $cartItems->update(['qty' => $request->qty]);

        if ($cartItems) {
            return response()->json($cartItems, Response::HTTP_OK);
        }

        return response()->json(['message' => 'There was an error updating your cart item.'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     * @param $cartItemId
     * @return Response
     * 
     * @OA\Delete(
     *      path="/api/v1/cart-item/{cartItemId}",
     *      operationId="deleteCart",
     *      tags={"Cart"},
     *      summary="Delete existing cart item",
     *      description="Delete existing cart item",
     *      @OA\Parameter(
     *          name="cartItemId",
     *          description="Cart Item id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
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
    public function destroy($cartItemId)
    {
        $cartItem = CartItems::find($cartItemId);
        
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], Response::HTTP_NOT_FOUND);
        }

        $cartItem->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @OA\Post(
     *      path="/api/v1/checkout",
     *      operationId="checkout",
     *      tags={"Cart"},
     *      summary="Checkout and place order",
     *      description="Place an order",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
    public function checkout()
    {
        $user = User::where('id', Auth::id())->first();
        $order = Order::firstOrCreate(['user_id' => $user->cart->id]);
        foreach ($user->cart->items as $cartItem) {
            $product = Product::where('id', $cartItem->product_id)->first();
            OrderItems::firstOrCreate([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'qty' => $cartItem->qty,
                'price' => $cartItem->qty * $product->final_price,
            ]); 
        }

        $user->cart->items()->delete();
        $user->cart->delete();

        event(new OrderPlaced($user)); // fire this event to send a email

        return response()->json(['message' => 'Order successfully placed!'], Response::HTTP_OK);
    }
}

<?php

namespace Modules\Cart\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Entities\CartItems;
use Modules\Cart\Entities\Order;
use Modules\Cart\Entities\OrderItems;
use Modules\Cart\Events\OrderPlaced;
use Modules\Cart\Http\Requests\StoreCartItemRequest;
use Modules\Cart\Http\Requests\UpdateCartItemRequest;
use Modules\Product\Entities\Product;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreCartItemRequest $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

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

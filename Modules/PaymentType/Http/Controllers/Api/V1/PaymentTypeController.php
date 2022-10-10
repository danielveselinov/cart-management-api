<?php

namespace Modules\PaymentType\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\Cart;

class PaymentTypeController extends Controller
{
    public function selectPayment(Request $request)
    {
        $request->validate(['payment_type_id' => 'required']);

        $cart = Cart::where('user_id', Auth::id())->first();

        $cart->payment_type_id = $request->payment_type_id;
        $cart->save();

        return response()->json(['message' => 'Payment successfully selected!'], Response::HTTP_OK);
    }
}

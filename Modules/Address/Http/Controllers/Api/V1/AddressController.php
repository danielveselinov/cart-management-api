<?php

namespace Modules\Address\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Entities\Address;
use Modules\Address\Http\Requests\AddressStoreRequest;
use Modules\Address\Http\Requests\AddressUpdateRequest;
use Modules\Address\Transformers\AddressCollection;
use Modules\Address\Transformers\AddressResource;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(new AddressCollection(Address::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(AddressStoreRequest $request)
    {
        $address = Address::create([
            'user_id' => Auth::id(),
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'street' => $request->street,
            'building' => $request->building,
            'apartment' => $request->apartment,
            'landmark' => $request->landmark,
            'is_main' => $request->is_main
        ]);

        return response()->json(new AddressResource($address), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Address $address
     * @return Response
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $address->country_id = $request->country_id;
        $address->city_id = $request->city_id;
        $address->area = $request->area;
        $address->street = $request->street;
        $address->building = $request->building;
        $address->apartment = $request->apartment;
        $address->landmark = $request->landmark;
        $address->is_main = $request->is_main;

        $address->save();

        return response()->json(new AddressResource($address), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Address $address
     * @return Response
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

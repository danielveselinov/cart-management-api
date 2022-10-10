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
    public function selectAddress()
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/v1/address",
     *      operationId="getAddressesList",
     *      tags={"Addresses"},
     *      summary="Get list of addresses",
     *      description="Returns list of addresses",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AddressResource")
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
        return response()->json(new AddressCollection(Address::all()), Response::HTTP_OK);
    }

      /**
     * @OA\Post(
     *      path="/api/v1/address",
     *      operationId="storeAddress",
     *      tags={"Addresses"},
     *      summary="Store new address",
     *      description="Returns address data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AddressStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AddressResource")
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
     * @OA\Put(
     *      path="/api/v1/address/{id}",
     *      operationId="updateAddress",
     *      tags={"Addresses"},
     *      summary="Update existing address",
     *      description="Returns updated address data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Address id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AddressUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AddressResource")
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
     * @OA\Delete(
     *      path="/api/v1/address/{id}",
     *      operationId="deleteAddress",
     *      tags={"Addresses"},
     *      summary="Delete existing address",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Address id",
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
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace Modules\City\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CityStoreRequest;
use Modules\City\Transformers\CityCollection;
use Modules\City\Transformers\CityResource;

class CityController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/city",
     *      operationId="getCitiesList",
     *      tags={"Cities"},
     *      summary="Get list of all cities",
     *      description="Returns list of all cities",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CityResource")
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
        return response()->json(new CityResource(City::all()), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/city",
     *      operationId="storeCity",
     *      tags={"Cities"},
     *      summary="Store new city",
     *      description="Returns city data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CityStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CityResource")
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
    public function store(CityStoreRequest $request)
    {
        $city = City::create(['name' => $request->name, 'country_id' => $request->country_id]);

        return response()->json(new CityResource($city), Response::HTTP_CREATED);
    }

     /**
     * @OA\Delete(
     *      path="/api/v1/city/{id}",
     *      operationId="deleteCity",
     *      tags={"Cities"},
     *      summary="Delete existing city",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="City id",
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
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

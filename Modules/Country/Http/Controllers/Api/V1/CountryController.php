<?php

namespace Modules\Country\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;
use Modules\Country\Transformers\CountryCollection;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/country",
     *      operationId="getCountriesList",
     *      tags={"Countries"},
     *      summary="Get list of countries",
     *      description="Returns list of countries",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CountryCollection")
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
        return response()->json(new CountryCollection(Country::all()), Response::HTTP_OK);
    }
}

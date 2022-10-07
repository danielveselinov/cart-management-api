<?php

namespace Modules\City\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CityStoreRequest;
use Modules\City\Transformers\CityCollection;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(new CityCollection(City::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create(['name' => $request->name, 'country_id' => $request->country_id]);

        return response()->json(new CityCollection($city), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int City $city
     * @return Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

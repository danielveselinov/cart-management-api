<?php

namespace Modules\Country\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;
use Modules\Country\Transformers\CountryCollection;

class CountryController extends Controller
{
    public function index()
    {
        return response()->json(new CountryCollection(Country::all()), Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API v1 Server"
 * )
 * 
 * @OA\Tag(
 *      name="Users",
 *      description="API Endpoints for Authentication"
 * )
 * 
 * @OA\Tag(
 *      name="Categories",
 *      description="API Endpoints of Categories"
 * )
 *
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints of Products"
 * )
 * 
 * @OA\Tag(
 *      name="Cart",
 *      description="API Endpoints of Cart"
 * )
 * 
 * * @OA\Tag(
 *      name="Countries",
 *      description="API Endpoints of Countries"
 * )
 * 
 * * @OA\Tag(
 *      name="Cities",
 *      description="API Endpoints of Cities"
 * )
 * 
 * * @OA\Tag(
 *      name="Addresses",
 *      description="API Endpoints of Addresses"
 * )
 * 
 * * @OA\Tag(
 *      name="PaymentTypes",
 *      description="API Endpoints of PaymentTypes"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

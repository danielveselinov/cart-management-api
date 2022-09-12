<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Product Management API Documentation",
 *      description="Simple products management API that shows products and related categories. It will
        be a part of a module handling the cart functionalities and making orders.",
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
 *      description="Demo API Server"
 * )
 * 
 * @OA\Tag(
 *     name="Categories",
 *     description="API Endpoints of Categories"
 * )
 * @OA\Tag(
 *     name="Projects",
 *     description="API Endpoints of Projects"
 * )
 * 
 * @OA\PathItem(path="/api")
 */

class Controller
{
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    
    
   /**
     * @OA\Post(
     * path="/Signup",
     * summary="Register to tumblr",
     * description="User register to the website",
     * operationId="Signup",
     * tags={"Auth"},
     *  @OA\Parameter(
     *         name="Email",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="Password",
     *         in="query",
     *         required=true,
     *      ),
     *   @OA\Parameter(
     *         name="Blogname",
     *         in="query",
     *         required=true,
     *      ),
     *  
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Email"},
     *       required={"Password"},
     *       required={"Blogname"},
     *       @OA\Property(property="Email", type="email", format="email", example="tumblr.email@gmail.com"),
     *       @OA\Property(property="Password", type="string",format="Password", example="pass123"),
     *      @OA\Property(property="Blogname", type="string",format="Password", example="Winter-is-comming"),
     *    ),
     * ),
     *      @OA\Response(
     *           response=200,
     *            description="Registered Successfully",
     *          ),
     *       @OA\Response(
     *              response=422,
     *              description="Invalid Data",
     *          ),
     *    
     *     )   
     */
        public function Signup (Request $request)
        {

        }
}

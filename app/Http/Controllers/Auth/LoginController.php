<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/Login",
     * summary="Login for existing Email",
     * description="User Login to his email ",
     * operationId="Login",
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
     *  
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Email"},
     *       required={"Password"},
     *       @OA\Property(property="Email", type="email", format="email", example="tumblr.email@gmail.com"),
     *       @OA\Property(property="Password", type="string",format="Password", example="pass123"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Login Successfully",
     * ),
     * )
     */

    /**
     * check user data in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Login(Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     * path="/Logout",
     * summary="Logout from Email",
     * description="User Logout from his email ",
     * operationId="Logout",
     * tags={"Auth"},
     * @OA\Response(
     *    response=200,
     *    description="Logout Successfully",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * )
     */

    /**
     * logout user from his email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Logout()
    {
        //
    }

    
}

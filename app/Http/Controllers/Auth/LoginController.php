<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/login",
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
     *       description="UnAuthorized Access",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Login Successfully",
     * ),
     * )
     */
    public function Login(Request $request)
    {
        $login_credenials = [
            'email' =>  $request->email,
            'password'=> $request->password
        ];
        if (Auth::attempt($login_credenials)){
            //generate the token for the user 
            $user_login_token = auth()->user()->CreateToken('authToken')->accessToken;

            //now return this token on success login attempt
            return response()->json(['token'=>$user_login_token] ,200);
        }else{
            // wrong login user not authorized to our system error code 401
            return response()->json(['error' => 'UnAuthorized Access'],401);
        }
    }

    /**
     * @OA\Post(
     * path="/logout",
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
     *       description="UnAuthorized Access",
     *   ),
     * )
     */
    public function Logout()
    {
        // checking wether the user is authenticated
        if (auth()->check()) {
            //getting user token the revoke it
            $user_token = auth()->user()->token();
            $user_token->revoke();
            return response()->json(['message'=>'Logout Successfully'], 200);

        }else {
        // wrong login user not authorized to our system error code 401
             return response()->json(['error' => 'UnAuthorized Access'],401);
        }
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Misc\Helpers\Errors;
use App\Services\Auth\LoginService;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------|
    | This controller handles Login and Logout of existing users 
    |
   */
    protected $loginService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
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
     *      @OA\JsonContent(
     *       required={"token"},
     *       required={"user"},
     *       @OA\Property(property="user", type="string", format="text", example="{user data}"),
     *       @OA\Property(property="token", type="string",format="text", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiZTlmMWFiZTdhYjgyYzI2NzU4YTkxNzgzOWUzMTBhMDQwNWI0YzU5M2ZmNmJmNmQwZDA1MzQyZjczMTc2MGM1ZTFhYmFmMjc2MDYzOTE4MDAiLCJpYXQiOjE2MzcyNTM5NzEuMjY0ODQ1LCJuYmYiOjE2MzcyNTM5NzEuMjY0ODcxLCJleHAiOjE2Njg3ODk5NzEuMTMyNTE2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.m9s768g6BZQN53a1RC1fhvAqWCLR9l_9Y6INMcqFa72KBfuxgUE5ach1QA0NzCrM8ZZOryQNvl7rhpuLsvSx3YuVQARt8VXTjqT_MfqRhwIy8Xl1M9LQ95tJtTt3Z0OPh2Uc1rbyUv4QjRSOf0hYjOpxE5N0Wpd1HcZ5FidM1jKvQUcXOkoE2HafcG9KLAE19_Lm7FcH1T4gsx7jsQ5ACfgEkFxr-w66JXcRa9jVLKbTnA2KENm6YJPiLsjmtnwadSThY2dOqvM7EYEk45P-bHU-OMxFwF7NFsNKSC9vC8cM1PN3cyzJISo0vK-OWMmx8qbcz9b36LK4ucoel1XhatvXGw_APzyqz1LC7vK6Ojesv2ipafV7MVFLNxmXorDmjyFWo7_2uH_Kb3atAocyAaf6B7Q9PnkyiVKoLikJDz6bncigsM3a3_m0lZey_ESUkBi2fz1blHkkNWnTr-phJxKBBvncyg6VrKJe2CugGZ2j4QWh4tFMEunpvIJWZ8h7niKEIi-kPLN5VbFtcqxIIM4YDZEtpik_2ghh-73NCPXi6gfzWLisszaUpGMgrltfU3isGsXZVSmseb2HBdQv9OA4Y5w9P4oHVMvKiOVyIv3r-SKNxm9c-Vfxzc26KqgP3mC_ZmtR-2l0xPTcWzm2_0pTXFfj5C_XYEqNL3ktLwc"),
     *    ),
     * ),
     * )
     */
    public function Login(LoginRequest $request)
    {
        $loginCredenials =[
            'email' =>  $request->email,
            'password'=>  $request->password
        ];
        if ($this->loginService->CheckUserAuthorized($loginCredenials)){
            //generate the token for the user 
            $userLoginToken = $this->loginService->CreateUserToken(auth()->user());

            //now return this token on success login attempt
            return response()->json(['user'=>auth()->user(), 'token'=>$userLoginToken] ,200);
        }else{
            // wrong login user not authorized to our system error code 401
            return $this->error_response(Errors::ERROR_MSGS_401,['UnAuthorized Access'],401);
           // return response()->json(['error' => ['UnAuthorized Access']],401);
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
        if ($this->loginService->CheckUserAuthenticated()) {

            //getting user token the revoke it
            $this->loginService->RevokeUserToken(auth()->user());
            
            return response()->json(['message'=>'Logout Successfully'], 200);

        }else {
        // wrong login user not authorized to our system error code 401
             return response()->json(['error' => 'UnAuthorized Access'],401);
        }
    }
}
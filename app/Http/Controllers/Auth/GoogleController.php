<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Misc\Helpers\Errors;
use App\Http\Requests\Auth\GoogleRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;

class GoogleController extends Controller
{
    protected $RegisterService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(RegisterService $RegisterService)
    {
        $this->RegisterService = $RegisterService;
    }

    public function GoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $token = $user->token;
            //$user2 = Socialite::driver('google')->userFromToken($token);
            dd($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

      /**
    * @OA\Post(
    * path="/google/login",
    * summary="login with google to tumblr",
    * description="User register to the website",
    * operationId="login google",
    * tags={"Auth"},

    *  @OA\Parameter(
    *         name="token",
    *         in="query",
    *         required=true,
    *      ),
    *  
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"token"},
    *      @OA\Property(property="token", type="string", example="ya29.a0ARrdaM8q2Elie-PdEAJ9ned1PB-2G"),
    *    ),
    * ),
     * @OA\Response(
     *    response=201,
     *    description="Successfully",
     *  @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="success"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *              @OA\Property(property="email", type="string",format="text", example="ahmed.mohamed.abdelhamed2@gmail.com"),
     *              @OA\Property(property="blog_name", type="string", format="text", example="ahmed123"),
     *              @OA\Property(property="age", type="integer", example=26),
     *              @OA\Property(property="token", type="string", format="text", example="4Y9ZEJqWEABGHkzEXAqNI1F9UZKtKeZVdIChNXBapp9w7XP6mwQZeBXEebMU"),
     *           ),
     * ),
     * ),
    *       @OA\Response(
    *              response=422,
    *              description="Invalid Data",
    *          ),
    *    
    *     )   
    */
    /**
     * this function is used for google login of user 
     * @param $request
     * @return $response
     */
    public function GetUserFromGoogle(Request $request)
    {
        $token = $request->token;
        try {
            $google_user = Socialite::driver('google')->userFromToken($token);
        } catch (\Throwable $th) {
            $error['token'] = Errors::TOKEN_ERROR;
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }
        $check = User::where('email', $google_user->email)->first();
        // $check = User::where('google_id', $user->id)->first();
        if ($check) {
            $user = Auth::loginUsingId($check->id);
            $request['user'] = $user;
            try {
                $request['token'] = $user->CreateToken('authToken')->accessToken;
            } catch (\Throwable $th) {
                $error['token'] = Errors::GENERATE_TOKEN_ERROR;
                return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
            }
            $request['blog'] = Blog::where('id', $user->primary_blog_id)->first();

            //update user data
            $isUpdated = $this->RegisterService->UpdateUserData($user, $google_user->id);
            if (!$isUpdated)
                return $this->error_response(Errors::ERROR_MSGS_500, 'error to update user data', 500);
            $resource =  new RegisterResource($request);
            return $this->success_response($resource, 200);
        } else {
            $error['user'] = 'you should register first';
            return $this->error_response(Errors::ERROR_MSGS_401, $error, 401);
        }
    }


     /**
    * @OA\Post(
    * path="/google/signup",
    * summary="signup with google to tumblr",
    * description="User register to the website",
    * operationId="Signup google",
    * tags={"Auth"},

    *  @OA\Parameter(
    *         name="token",
    *         in="query",
    *         required=true,
    *      ),
    *  @OA\Parameter(
    *         name="blog_name",
    *         in="query",
    *         required=true,
    *      ),
    *  @OA\Parameter(
    *         name="age",
    *         in="query",
    *         required=true,
    *      ),
    *  
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"token","blog_name","age"},
    *      @OA\Property(property="token", type="string", example="ya29.a0ARrdaM8q2Elie-PdEAJ9ned1PB-2G"),
    *      @OA\Property(property="blog_name", type="string", example="AHmed1"),
    *      @OA\Property(property="age", type="integer", example=22),
    *    ),
    * ),
     * @OA\Response(
     *    response=201,
     *    description="Successfully",
     *  @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="success"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *              @OA\Property(property="email", type="string",format="text", example="ahmed.mohamed.abdelhamed2@gmail.com"),
     *              @OA\Property(property="blog_name", type="string", format="text", example="ahmed123"),
     *              @OA\Property(property="age", type="integer", example=26),
     *              @OA\Property(property="token", type="string", format="text", example="4Y9ZEJqWEABGHkzEXAqNI1F9UZKtKeZVdIChNXBapp9w7XP6mwQZeBXEebMU"),
     *           ),
     * ),
     * ),
    *       @OA\Response(
    *              response=422,
    *              description="Invalid Data",
    *          ),
    *    
    *     )   
    */
    /**
     * this function is used for google signup of user 
     * @param $request
     * @return $response
     */
    public function SignUpWithGoogle(GoogleRequest $request)
    {
        try {
            $google_user = Socialite::driver('google')->userFromToken($request->token);
        } catch (\Throwable $th) {
            $error['token'] = Errors::TOKEN_ERROR;
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }
        // check if the user is already a user 
        $user = User::where('email', $google_user->email)->first();
        if ($user) {
            $user = Auth::loginUsingId($user->id);
            try {
                $userLoginToken = $user->CreateToken('authToken')->accessToken;
                $request['token'] = $userLoginToken;
            } catch (\Throwable $th) {
                $error['token'] = Errors::GENERATE_TOKEN_ERROR;
                return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
            }
            $request['user'] = $user;
            $request['blog'] = Blog::where('id', $user->primary_blog_id)->first();
            $user->google_id = $google_user->id;
            $user->save;
            $resource =  new RegisterResource($request);
            return $this->success_response($resource, 200);
        }

        // create user
        $user = $this->RegisterService->CreateUserGoogle($google_user->email, $request->age, $google_user->id);
        if (!$user) {
            $error['user'] = Errors::CREATE_ERROR;
            $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
        }

        // create blog
        $blog = $this->RegisterService->CreateBlog($request->blog_name, $user);
        if (!$blog)
            return $this->error_response(Errors::ERROR_MSGS_500, Errors::CREATE_ERROR, 500);

        // link user with blog
        $link_user_blog = $this->RegisterService->LinkUserBlog($user, $blog);
        if (!$link_user_blog)
            return $this->error_response(Errors::ERROR_MSGS_500, 'link error', 500);

        //create the access token to the user  
        $generate_token = $this->RegisterService->GenerateToken($user);
        if (!$generate_token)
            return $this->error_response(Errors::ERROR_MSGS_500, ERRORS::GENERATE_TOKEN_ERROR, 500);

        $request['blog'] = $blog;
        $request['token'] = $user->token();

        // this method will return true if authentication was successful
        if (Auth::loginUsingId($user->id)) {
            $request['user'] = Auth::user();
            // Fire Registered event
            event(new Registered($user));
            $resource =  new RegisterResource($request);
            return $this->success_response($resource, 201);
        }
        return $this->error_response(Errors::ERROR_MSGS_500, Errors::CREATE_ERROR, 500);
    }
}
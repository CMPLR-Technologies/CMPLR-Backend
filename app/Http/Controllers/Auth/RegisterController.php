<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Misc\Helpers\Errors;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ValidateRegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Services\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------|
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
   */
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

   /**
    * @OA\Post(
    * path="/register/validate",
    * summary="Register to tumblr",
    * description="For web only",
    * operationId="Signup validate",
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
    *         name="blog_name",
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
    *       @OA\Property(property="email", type="email", format="email", example="tumblr.email@gmail.com"),
    *       @OA\Property(property="password", type="string",format="Password", example="pass123"),
    *      @OA\Property(property="Blog_name", type="string",format="Password", example="Winter-is-comming"),
    *    ),
    * ),
    *      @OA\Response(
    *           response=200,
    *            description="successful",
    *          ),
    *       @OA\Response(
    *              response=422,
    *              description="Invalid Data",
    *          ),
    *    
    *     )   
    */
   /**
    * This Function used to validate the Registertion request
    * @param  RegisterRequest
    * 
    * @return response
    */
   public function ValidateRegister(ValidateRegisterRequest $request)
   {
      return $this->success_response((['email' => $request->email]));
   }


   /**
    * @OA\Post(
    * path="/register/insert",
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
    *         name="blog_name",
    *         in="query",
    *         required=true,
    *      ),
    *   @OA\Parameter(
    *         name="age",
    *         in="query",
    *           
    *         required=true,
    *      ),
    *  
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"Email"},
    *       required={"Password"},
    *       required={"blog_name"},
    *       required={"age"},
    *       @OA\Property(property="email", type="email", format="email", example="tumblr.email@gmail.com"),
    *       @OA\Property(property="password", type="string",format="Password", example="pass123"),
    *      @OA\Property(property="Blog_name", type="string",format="Password", example="Winter-is-comming"),
    *      @OA\Property(property="age", type="integer", example=26),
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
    * Register function use to hanle the Registertion process of user
    * @param RegisterRequest $request (holds the validated request)
    *
    * @return response
    */
   public function Register(RegisterRequest $request)
   {
      // create user with given parameters
      $user = $this->RegisterService->CreateUser($request->email, $request->age, $request->password);
      if (!$user)
         return $this->error_response(Errors::ERROR_MSGS_500, Errors::CREATE_ERROR, 500);

      // create blog with given parameters
      $blog = $this->RegisterService->CreateBlog($request->blog_name, $user);
      if (!$blog)
         return $this->error_response(Errors::ERROR_MSGS_500, Errors::CREATE_ERROR, 500);

      // link user with blog
      $linkUserBlog = $this->RegisterService->LinkUserBlog($user, $blog);
      if (!$linkUserBlog)
         return $this->error_response(Errors::ERROR_MSGS_500, 'link error', 500);

      //create the access token to the user   
      $generateToken = $this->RegisterService->GenerateToken($user);
      if (!$generateToken)
         return $this->error_response(Errors::ERROR_MSGS_500, ERRORS::GENERATE_TOKEN_ERROR, 500);

      $request['blog'] = $blog;
      $request['token'] = $user->token();

      // this method will return true if authentication was successful
      if (Auth::attempt($request->only('email', 'age', 'password'))) {
         $user = Auth::user();
         $request['user'] = $user;
         // Fire Registered event
         event(new Registered($user));
         $resource =  new RegisterResource($request);
         return $this->success_response($resource, 201);
      }

      return $this->error_response(Errors::ERROR_MSGS_500, Errors::CREATE_ERROR, $code = 500);
   }
}
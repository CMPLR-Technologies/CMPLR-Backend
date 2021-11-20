<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use \App\Models\User;
use \App\Models\Blog;
use App\Notifications\WelcomeEmailNotification;
use App\Services\Auth\RegisterService;

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

   public function ValidateRegister(RegisterRequest $request)
   {
      return $this->success_response((['email' => $request->email]));
   }


   /**
    * @OA\Post(
    * path="/signup",
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
   public function Register(RegisterRequest $request)
   {

      $user = $this->RegisterService->CreateUser($request->email, $request->age, $request->password);

      if (!$user)
         return $this->error_response('Error While creating', 500);


      $blog = $this->RegisterService->CreateBlog($request->blog_name);

      if (!$blog)
         return $this->error_response('Error While creating', 500);

      $generate_token = $this->RegisterService->GenerateToken($user);

      if (!$generate_token)
         return $this->error_response('Error Generating Token', 500);

      $request['blog_name'] = $blog->blog_name;
      $request['token'] = $user->token();

      if (Auth::attempt($request->only('email', 'age', 'password'))) {
         $resource =  new RegisterResource($request);
         $user->notify(new WelcomeEmailNotification());
         return $resource->response()->setStatusCode(201);
      }

      return $this->error_response('Error While creating', 500);
   }
}
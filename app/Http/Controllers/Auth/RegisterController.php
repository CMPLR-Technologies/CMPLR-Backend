<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use \App\Models\User;
use \App\Models\Blog;

class RegisterController extends Controller
{

   public function ValidateRegister(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'blog_name' => ['required','unique:blogs','max:255'],
         'email' => ['required','email','unique:users','max:255'],
         'password' => ['required','string',Password::min(8) 
                                             ->mixedCase()     
                                             ->letters()
                                             ->numbers()
                                             ->symbols()
                                             ->uncompromised()],
         ]);

         if ($validator->fails()) {
              return response()->json(['error'=>$validator->errors()], 401);
         }
        
         return response()->json(['response'=>$request->email],200);
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
      try {
         $user = User::create([
            'email' => $request->email,
            'age' => $request->age,
            'password' => Hash::make($request->password)
         ]);
      } catch (\Exception $exception) {
         return response()->json(['error' => 'Error While creating'], 400);
      }
    
      try {
         $blog = Blog::create([
            'blog_name' => $request->blog_name,
            'url' => 'https' . $request->blog_name . 'tumblr.com',
         ]);
      } catch (\Throwable $th) {
         return response()->json(['error' => 'Error While creating'], 400);
      }
   
      $request['token'] = $user->createToken('tumblr_token')->accessToken;
      $request['blog_name'] = $blog->blog_name;

      if (Auth::attempt($request->only('email','age','password'))) 
      {
         return new RegisterResource($request);
      }

      return response()->json(['error' => 'Error While Registeration'], 400);
   }
}

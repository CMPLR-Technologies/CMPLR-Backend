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
use App\services\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;

class GoogleController extends Controller
{
    protected $RegisterService;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct( RegisterService $RegisterService)
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
            $user = Socialite::driver('google')->user();
            $token = $user->token;
            //$user2 = Socialite::driver('google')->userFromToken($token);
            dd($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


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
            $request['blog'] = Blog::where('id',$user->primary_blog_id)->first();
            $user->google_id = $google_user->id;
            $user->save;
            $resource =  new RegisterResource($request);
            return $this->success_response($resource,201);
        } else {
            $error['user'] = 'you should register first';
            return $this->error_response(Errors::ERROR_MSGS_401, $error, 401);
        }
    }

    /**
     * this function is responsible for 
     */
    public function SignUpWithGoogle(GoogleRequest $request)
    {
        try {
            $user = Socialite::driver('google')->userFromToken($request->token);
        } catch (\Throwable $th) {
            $error['token'] = Errors::TOKEN_ERROR;
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }
        // check if the user is already a user 
        if (User::where('email', $user->email)->first()) 
        {
            $user = Auth::loginUsingId($user->id);
            try {
                $userLoginToken = $user->CreateToken('authToken')->accessToken;
            } catch (\Throwable $th) {
                $error['token'] = Errors::GENERATE_TOKEN_ERROR;
                return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
            }
            //TODO: return register resource
            return response()->json(['user' => auth()->user(), 'token' => $userLoginToken], 200);
        }

        // create user
        $user = $this->RegisterService->CreateUserGoogle($user->email, $request->age, $user->id);
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

        $request['blog']=$blog;
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

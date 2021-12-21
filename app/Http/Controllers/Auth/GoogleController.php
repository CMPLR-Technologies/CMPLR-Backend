<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Misc\Helpers\Errors;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
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

  //  public function Googlelogin( Request $request ) { 
        // $provider = "google";
        // $token = $request->input('access_token');
         
        // $providerUser = Socialite::driver($provider)->userFromToken($token);
        // dd($providerUser);
        // $expiresIn=$accessTokenResponse["expires_in"];
        // $idToken=$accessTokenResponse["id_token"];
        // $refreshToken=isset($accessTokenResponse["refresh_token"])?$accessTokenResponse["refresh_token"]:"";
        // $tokenType=$accessTokenResponse["token_type"];
        // $user = Socialite::driver('google')->userFromToken($accessToken);
     
   // }

   public function GetUserFromGoogle(Request $request)
   {
        $token = $request->route('token');
        //dd($token);
        $user = Socialite::driver('google')->userFromToken($token);
        
        $check = User::where('email',$user->email)->first();
        if($check)
        {

            return $this->success_response('login');
        }
        else
        {
            
            return $this->error_response(Errors::ERROR_MSGS_401,'register',401);     
        }
   }
}

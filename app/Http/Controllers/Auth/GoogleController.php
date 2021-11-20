<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function handleCallback(Request $request)
    // {
    //     try {
    //         $adwords_api_response = Socialite::with('google')->getAccessTokenResponse($request->code);

    //         $user = Socialite::driver('google')->user();

    //         $finduser = User::where('google_id', $user->id)->first();

    //         // if there is already a user with this Google id => login 
    //         // else create a new user with this google_id
    //         if ($finduser) {

    //             Auth::login($finduser);

    //             return (new RegisterResource($finduser));
    //         } else {
    //             $newUser = User::create([
    //                 'firstName' => $user['given_name'],
    //                 'lastName' => $user['family_name'],
    //                 'email' => $user['email'],
    //                 'google_id' => $user['id'],
    //                 'email_verified_at' => Carbon::now()->timestamp,
    //                 'password' => 'N/A',
    //             ]);

    //             //Auth::login($newUser);

    //             return (new RegisterResource($newUser));
    //         }
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }

    public function Googlelogin( Request $request ) { 
        // $provider = "google";
        // $token = $request->input('access_token');
         
        // $providerUser = Socialite::driver($provider)->userFromToken($token);
        // dd($providerUser);
        // $expiresIn=$accessTokenResponse["expires_in"];
        // $idToken=$accessTokenResponse["id_token"];
        // $refreshToken=isset($accessTokenResponse["refresh_token"])?$accessTokenResponse["refresh_token"]:"";
        // $tokenType=$accessTokenResponse["token_type"];
        // $user = Socialite::driver('google')->userFromToken($accessToken);
     
    }
}

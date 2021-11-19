<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            // if there is already a user with this Google id => login 
            // else create a new user with this google_id
            if ($finduser) {

                Auth::login($finduser);

                return (new RegisterResource($finduser));
            } else {
                $newUser = User::create([
                    'firstName' => $user['given_name'],
                    'lastName' => $user['family_name'],
                    'email' => $user['email'],
                    'google_id' => $user['id'],
                    'email_verified_at' => Carbon::now()->timestamp,
                    'password' => 'N/A',
                ]);

                //Auth::login($newUser);

                return (new RegisterResource($newUser));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

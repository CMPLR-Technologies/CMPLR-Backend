<?php

namespace App\Services\Auth;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{


    /**
     * Check if email received is corresponding to a user or not
     *
     * @param string $email
     * 
     * @return User
     */
    public function GetUser(string $email): User
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    /**
     * Check if email and token both related to same user
     *
     * 
     * @return Bool
     */
    public function CheckEmailToken($email,$token): Bool
    {
        $passwordResets = DB::table('password_resets')->where(['email'=>$email, 'token'=>$token])
                                                      ->first();
        //dd($passwordResets );
        if($passwordResets == null)
            return false;
        else 
            return true;    
    }


 
    /**
     *  set the new password for user and delete the token  
     *
     * @param string $email
     * @param string $token
     * 
     * @return bool
     */
    public function SetNewPassword(User $user, string $new_password): bool
    {
        try {
            $user->password=Hash::make($new_password);
            $user->save();
            DB::table('password_resets')->where('email',$user->email)->delete();
            //dd($del);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}

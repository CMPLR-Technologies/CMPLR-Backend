<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
    public function GetUser(string $email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    /**
     * Check if email and token both related to same user
     *  
     * @param string $email
     * @param string $token
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
     * if new password matches old password return false
     * @param string $old_password (current_user->password)
     * @param string $newpassword
     * 
     * @return bool
     */
    public function CheckPassword(string $oldPassword, string $newPassword): bool
    {   
        if (Hash::check($newPassword, $oldPassword)) 
            return false;

        return true;    
    }
 
    /**
     *  set the new password for user and delete the token  
     *
     * @param User $user
     * @param string $new_password
     * 
     * @return bool
     */
    public function SetNewPassword(User $user, string $newPassword): bool
    {
        try {
            $user->password=Hash::make($newPassword);
            $user->save();
            DB::table('password_resets')->where('email',$user->email)->delete();
            //dd($del);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}

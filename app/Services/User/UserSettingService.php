<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSettingService
{


    /**
     * get Authenticated User.
     *
     * @return User
     */
    public function GetAuthUser()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Get all the settings(account,dashboard, notification) for the user
     *
     * @param integer $age
     * 
     * @return object
     */
    public function GetSettings(int $user_id)
    {
        $data = User::where('id', $user_id)
            ->get()->first()->makeHidden([
                'email_verified_at',
                'password',
                'first_name',
                'last_name',
                'age',
                'following_count',
                'likes_count',
                'default_post_format',
                'google_id',
                'created_at',
                'updated_at'
            ]);
        if (!$data)
            return null;
        return $data;
    }

    /**
     * Update all user settings(account,dashboard, notification) 
     * @param int $user_id 
     * @param array $data
     *   
     * @return object
     */
    public function UpdateSettings(int $user_id,array $data)
    {
        try {
            User::where('id', $user_id)->update($data);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    // Change Password

    /**
     * Confirm if the User enter his password correctly
     * 
     * @param string Password
     * @param string User hashed-Password  
     * 
     * @return bool
     */
    public function ConfirmPassword(string $password, string $hashed_password): bool
    {
        $check = Hash::check($password, $hashed_password);
        if (!$check)
            return false;
        return true;
    }

    
    /**
     * Update User Email
     * 
     * @param User $user
     * @param string $new_email  
     * 
     * @return bool
     */
    public function UpdateEmail(int $user_id, string $new_email)
    {
        try {
            $user = User::where('id',$user_id)->first();
            $user->update(['email'=>$new_email]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    /**
     * update user password
     * @param User $user
     * @param string $new_password
     * 
     * @return bool
     */
    public function UpdatePassword(int $user_id, string $new_password):bool
    {
        try {
            $user = User::where('id',$user_id)->first();
            $new_password =  Hash::make($new_password);
            $user->update(['password'=>$new_password]);
        } catch (\Throwable $th) {
            return false;
        }
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
    public function CheckPassword(string $old_Password, string $new_password): bool
    {   
        if (Hash::check($new_password, $old_Password)) 
            return false;

        return true;    
    }
}

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
    public function UpdateSettings(int $userId,array $data)
    {
        try {
            User::where('id', $userId)->update($data);
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
    public function ConfirmPassword(string $password, string $hashedPassword): bool
    {
        $check = Hash::check($password, $hashedPassword);
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
    public function UpdateEmail(int $userId, string $newEmail)
    {
        try {
            $user = User::where('id',$userId)->first();
            $user->update(['email'=>$newEmail]);
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
    public function UpdatePassword(int $userId, string $newPassword):bool
    {
        try {
            $user = User::where('id',$userId)->first();
            $newPassword =  Hash::make($newPassword);
            $user->update(['password'=>$newPassword]);
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
    public function CheckPassword(string $oldPassword, string $newPassword): bool
    {   
        if (Hash::check($newPassword, $oldPassword)) 
            return false;

        return true;    
    }
}

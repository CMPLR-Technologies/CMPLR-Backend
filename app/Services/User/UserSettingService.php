<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        if(!$data)
            return null;
        return $data;
    }
}

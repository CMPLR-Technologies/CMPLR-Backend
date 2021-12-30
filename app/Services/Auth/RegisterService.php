<?php

namespace App\Services\Auth;

use App\Http\Misc\Helpers\Errors;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{


    /**
     * Adds a new user to DataBase.
     *
     * @param string $email
     * @param integer $age
     * @param string $password
     * @return User
     */
    public function CreateUser(string $email, int $age, string $password)
    {
        try {
            $user = User::create([
                'email' => $email,
                'age' => $age,
                'password' => Hash::make($password)
            ]);
        } catch (\Throwable $th) {
            return null;
        }
        if (!$user)
            return null;
        return $user;
    }

    public function CreateUserGoogle(string $email, int $age, string $googleId)
    {
        try {
            $user = User::create([
                'email' => $email,
                'age' => $age,
                'google_id' => $googleId,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('N/A')
            ]);
        } catch (\Throwable $th) {
            return null;
        }
        if (!$user)
            return null;
        return $user;
    }

    /**
     * Adds the primary blog of the registered user to DataBase.
     *
     * @param string $Blog_name
     * @param User $user
     * 
     * @return Blog
     */
    public function CreateBlog(string $blogName, User $user)
    {
        try {
            $blog_url = env('APP_URL') . '/blogs/' . $blogName;
            $blog = Blog::create([
                'blog_name' => $blogName,
                'url' => $blog_url,
            ]);
            DB::table('blog_settings')->insert([
                'blog_id' => $blog->id,
            ]);
            $user->primary_blog_id = $blog->id;
            $user->save();
        } catch (\Throwable $th) {
            //if blog creation failed so we should delete the user 
            // to make all processes as package(ensure that all are done or all failed)
            User::find($user->id)->delete();
            return null;
        }
        if (!$blog)
            return null;
        return $blog;
    }


    /**
     * Adds the primary blog of the registered user to DataBase.
     *
     * @param User $user
     * @param blog $blog
     * 
     * @return bool
     */
    public function LinkUserBlog(User $user, Blog $blog)
    {
        try {
            $check = DB::table('blog_users')->insert([
                'user_id' => $user->id,
                'blog_id' => $blog->id,
                'primary' => true,
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        if (!$check)
            return false;
        return true;
    }


    /**
     * Generate the Token to the user 
     *
     * @param user $user
     * 
     * @return Bool
     */
    public function GenerateToken(User $user): Bool
    {
        if (!$user)
            return false;
        else {
            //Generate the accessToken to the user 
            $token = $user->createToken('User_access_token')->accessToken;
            $user->withAccessToken($token);
            return true;
        }
    }


    public function GoogleLogin(User $user,string $googleUserId)
    {
        $request['user'] = $user;
        try {
            $request['token'] = $user->CreateToken('authToken')->accessToken;
            $request['blog'] = Blog::where('id',$user->primary_blog_id)->first();
            $user->google_id = $googleUserId;
            $user->save;
        } catch (\Throwable $th) {
            return null;
        }
        return $request;
    }
}

<?php

namespace App\Services\Auth;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService{


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
        if(!$user)
            return null;
        return $user;
        
        
    }

     /**
     * Adds the primary blog of the registered user to DataBase.
     *
     * @param string $Blog_name
     * 
     * @return Blog
     */
    public function CreateBlog(string $blog_name,int $user_id)
    {
        try {
            $blog_url = 'https://www' . $blog_name . 'tumblr.com';
            $blog = Blog::create([
                'blog_name' => $blog_name,
                'url' => $blog_url,
            ]);
            DB::table('blog_settings')->insert([
                'blog_id'=>$blog->id,
            ]);
        } catch (\Throwable $th) {
            //if blog creation failed so we should delete the user 
            // to make all processes as package(ensure that all are done or all failed)
            User::find($user_id)->delete();
            return null;
        }
        if(!$blog)
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
        if(!$check)
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
    public function GenerateToken(User $user):Bool
    {
        if(!$user)
            return false;
        else
        {
            //Generate the accessToken to the user 
            $token = $user->createToken('User_access_token')->accessToken;
            $user->withAccessToken($token);
            return true;
        } 
    }

}

?>

<?php

namespace App\Services\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Blog;

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
        return $user;
        
        
    }

     /**
     * Adds the primary blog of the registered user to DataBase.
     *
     * @param string $Blog_name
     * 
     * @return Blog
     */
    public function CreateBlog(string $blog_name)
    {
        try {
            $blog_url = 'https' . $blog_name . 'tumblr.com';
            $blog = Blog::create([
                'blog_name' => $blog_name,
                'url' => $blog_url,
            ]);
        } catch (\Throwable $th) {
            return null;
        }
        return $blog;
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
<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use App\Services\Auth\RegisterService;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{

    /**
     * check successful create of user
     *
     * @return void
     */
    public function test_Successful_Create_User()
    {  
        $email = str::random(10).'@gmail.com';
        $age =  rand(16,119);
        $password =str::random(10); 
        $check = (new RegisterService())->CreateUser($email,$age,$password); 
        $this->assertNotNull($check);
    }

    /**
     * check failure create of user
     *
     * @return void
     */
    public function test_Failure_Create_User()
    {  
        $user = User::take(1)->first();
        $check = (new RegisterService())->CreateUser($user->email,22,"Ahmed_123"); 
        $this->assertNull($check);
    }


    /**
     * check successful create of Blog
     *
     * @return void
     */
    public function test_Successful_Create_Blog()
    {  
        $user = User::take(1)->first();
        $blog_name = str::random(10);
        $blog_url = 'https' . $blog_name . 'tumblr.com';
        $check = (new RegisterService())->CreateBlog($blog_name,$user->id); 
        $this->assertNotNull($check);
    }

    
    /**
     * check successful create of Blog
     * Enter 
     *
     * @return void
     */
    public function test_Failure_Create_Blog()
    {  
        $blog = Blog::take(1)->first();
        $user = User::take(1)->first();
        $check = (new RegisterService())->CreateBlog($blog->blog_name,$user->id); 
        $this->assertNull($check);
    }
}

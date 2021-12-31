<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use App\Services\Auth\RegisterService;
use Faker\Factory;
use Illuminate\Support\Str;
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
        $email = str::random(10) . '@gmail.com';
        $age =  rand(16, 119);
        $password = str::random(10);
        $check = (new RegisterService())->CreateUser($email, $age, $password);
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
        $check = (new RegisterService())->CreateUser($user->email, 22, "Ahmed_123");
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
        $check = (new RegisterService())->CreateBlog($blog_name, $user);
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
        $check = (new RegisterService())->CreateBlog($blog->blog_name, $user);
        $this->assertNull($check);
    }



    /** @test */
    public function SuccesfullValidateRegister()
    {
        $this->post('api/register/validate', [
            'email' => Str::random(10) . '@gmail.com',
            'blog_name' => Str::random(10),
            'password' => 'Winter_217'
        ])->assertStatus(200);
    }

    /** @test */
    //try exist email
    public function FailureValidateRegister1()
    {
        $user = User::first();
        $this->post('api/register/validate', [
            'email' => $user->email,
            'blog_name' => Str::random(10),
            'password' => 'Winter_217'
        ])->assertStatus(422);
    }

    /** @test */
    // try exist blog_name
    public function FailureValidateRegister2()
    {
        $blog = Blog::take(1)->first();
        $this->post('api/register/validate', [
            'email' => Str::random(10),
            'blog_name' => $blog->blog_name,
            'password' => 'Winter_217'
        ])->assertStatus(422);
    }

    /** @test */
    // try unvalid password
    public function FailureValidateRegister3()
    {
        $this->post('api/register/validate', [
            'email' => Str::random(10),
            'blog_name' => Str::random(15),
            'password' => 'Winter_217'
        ])->assertStatus(422);
    }

    /** @test */
    // try invalid age
    public function FailureValidateRegister4()
    {
        $this->post('api/register/insert', [
            'email' => Str::random(10),
            'blog_name' => Str::random(15),
            'password' => 'Winter_217',
            'age' => 145
        ])->assertStatus(400);
    }

    //Test Google login and signup
    
    /** @test */
    // try to update user
    public function TestUpdateUserData()
    {
        $user = User::take(1)->first();
        $check = (new RegisterService())->UpdateUserData($user, "123456");
        $this->assertNotNull($check);
    }

    /** @test */
    // try to createuserUsing Google data
    public function TestCreateUserGoogle()
    {
        $check = (new RegisterService())->CreateUserGoogle(time() . 'email' . '@gmail.com', 22, "123456");
        $this->assertNotNull($check);
    }

    /** @test */
    // try to createuserUsing Google data
    public function TestCreateUserGoogleFailure()
    {
        $user = User::take(1)->first();
        $check = (new RegisterService())->CreateUserGoogle($user->email, 22, "123456");
        $this->assertNull($check);
    }
}

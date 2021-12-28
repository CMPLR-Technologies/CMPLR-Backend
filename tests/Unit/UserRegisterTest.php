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

    // try invalid age
    /** @test */
    public function FailureValidateRegister4()
    {
        $this->post('api/register/insert', [
            'email' => Str::random(10),
            'blog_name' => Str::random(15),
            'password' => 'Winter_217',
            'age' => 145
        ])->assertStatus(400);
    }

    // try successful response and check if the token is generated correctly
    /** @test */
    public function SuccessfullResponse()
    {
        $faker = Factory::create(1);
        $request = [
            'email' => $faker->email(),
            'age' => $faker->numberBetween(18, 80),
            'blog_name' => $faker->randomLetter(20),
            'password' => $faker->password(8,20),
        ];
        // only needs user to test user settings
        $response = $this->json('POST', '/api/register/insert', $request, ['Accept' => 'application/json']);
       // dd($response);
        $token = ($response->json())['response']['token'];
        $this->assertNotNull($token);
    }
    
}

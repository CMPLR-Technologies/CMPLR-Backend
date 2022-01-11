<?php

namespace Tests\Unit;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Blog;
use App\Models\User;
use App\Services\Auth\RegisterService;
use Faker\Factory;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new RegisterRequest())->rules();
        $this->validator = $this->app['validator'];
    }

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

    // validation

    /**
     * check the validation of blog name
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateBLogName()
    {
        $this->assertTrue($this->validateField('blog_name', 'Ahmed_12'));
        $this->assertTrue($this->validateField('blog_name', 'AHmed'));
        $this->assertTrue($this->validateField('blog_name', '12_Ahmed'));


        // blog_name cannot be 

        //empty
        $this->assertFalse($this->validateField('blog_name', ''));
        // already taken name
        $blog = Blog::take(1)->first()->blog_name;
        $this->assertFalse($this->validateField('blog_name', $blog));
        // more than 22 characters
        $this->assertFalse($this->validateField('blog_name', 'jondfgdfgfdgsdfgdsfdfsdfgfdsg'));
        // contain special characters
        $this->assertFalse($this->validateField('blog_name', 'ahmed $#@1'));
    }

    /**
     * check the validation of age
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateAge()
    {
        $this->assertTrue($this->validateField('age', 25));
        $this->assertTrue($this->validateField('age', 22));
        $this->assertTrue($this->validateField('age', 79));
        $this->assertTrue($this->validateField('age', '69'));

        // age  cannot be 

        //empty
        $this->assertFalse($this->validateField('age', ''));
        // string
        $this->assertFalse($this->validateField('age', 'aa'));
        // more than 80
        $this->assertFalse($this->validateField('age', 1000));
        //less than 18
        $this->assertFalse($this->validateField('age', 10));
    }

    /**
     * check the validation of email
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateEmail()
    {
        $this->assertTrue($this->validateField('email', 'ahmedmail@gmail.com'));
        $this->assertTrue($this->validateField('email', 'ahmedemail@hotmail.com'));

        // Email  cannot be 
        //empty
        $this->assertFalse($this->validateField('email', ''));
        //invalid email form 
        $this->assertFalse($this->validateField('email', 'ahmed'));
        $this->assertFalse($this->validateField('email', 'ahmed@'));
        $this->assertFalse($this->validateField('email', '12345'));
        // already taken email
        $userEmail = User::take(1)->first()->email;
        $this->assertFalse($this->validateField('email', $userEmail));
    }

    /**
     * check the validation of password
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validatePassword()
    {
        $this->assertTrue($this->validateField('password', 'HardPass_123'));
        $this->assertTrue($this->validateField('password', '@#A$#askd1x'));

        // Password  cannot be 
        //empty
        $this->assertFalse($this->validateField('password', ''));
        //only lower case
        $this->assertFalse($this->validateField('password', 'ahmedsss'));
        // only numbers
        $this->assertFalse($this->validateField('password', '123455'));
        // only upper case
        $this->assertFalse($this->validateField('password', 'AHMED'));
        // less than 8 characters
        $this->assertFalse($this->validateField('password', 'Aa@123'));
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



    protected function getFieldValidator($field, $value)
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    protected function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}

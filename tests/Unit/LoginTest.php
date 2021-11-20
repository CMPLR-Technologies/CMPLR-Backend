<?php

namespace Tests\Unit;

use App\Services\Auth\LoginService; 
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * testing wether the login user authorized to our system 
     *
     * @return void
     */
    protected $loginService;
   

    public function test_successful_user_authorized()
    {

        $loginCredenials =[
            'email' =>   User::take(1)->first()->value('email'),
            'password'=> '$2y$10$92IXUNpkjO0rOQ5by'
        ];
        
        $check =(new LoginService())->CheckUserAuthorized($loginCredenials);
        $this->assertTrue($check);
    }

    public function test_failure_user_authorized()
    {
        $loginCredenials =[
            'email' =>  'leland97@example.com',
            'password'=> '$2XUNpkjO0rOQ5by'
        ];
        $check =(new LoginService())->CheckUserAuthorized($loginCredenials);
        $this->assertFalse($check);
    }

    public function test_successful_creat_token()
    {
        $user = User::take(1)->first();
        $check =(new LoginService())->CreateUserToken($user);
        $this->assertNotNull($check);
    }

    

}

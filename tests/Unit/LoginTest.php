<?php

namespace Tests\Unit;

use App\Models\User; 
use App\Services\Auth\LoginService;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * testing Succesful authorized user
     * Test CheckUserAuthorized which check wether the login user authorized to our system 
     *
     * @return void
     */   
    public function test_successful_user_authorized()
    {

        $loginCredenials =[
            'email' =>   User::take(1)->first()->value('email'),
            'password'=> 'Ahmed_123',
        ];
        
        $check =(new LoginService())->CheckUserAuthorized($loginCredenials);
        $this->assertTrue($check);
    }

    /**
     * testing failure authorized user
     * Test CheckUserAuthorized which check wether the login user authorized to our system 
     *
     * @return void
     */   
    public function test_failure_user_authorized()
    {
        $loginCredenials =[
            'email' =>  'leland97@example.com',
            'password'=> '$2XUNpkjO0rOQ5by',
        ];
        $check =(new LoginService())->CheckUserAuthorized($loginCredenials);
        $this->assertFalse($check);
    }

    /**
     * testing successful create user token
     * Test CreateUserToken which create token for the user
     *
     * @return void
     */ 
    public function test_successful_creat_token()
    {
        $user = User::take(1)->first();
        $check =(new LoginService())->CreateUserToken($user);
        $this->assertNotNull($check);
    }

    

}

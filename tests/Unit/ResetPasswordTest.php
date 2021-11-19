<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Services\Auth\ResetPasswordService;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResetPasswordTest extends TestCase
{
    /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Successful_GetUser()
    {
        $user = User::take(1)->first();
        $check = (new ResetPasswordService())->GetUser($user->email);
        $this->assertNotNull($check);
    }

      /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Failure_GetUser()
    {
        $email = str::random(10).'@gmail.com';
        $check = (new ResetPasswordService())->GetUser($email);
        $this->assertNull($check);
    }


    /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Successful_CheckEmailToken()
    {
        $reset_password =  DB::table('password_resets')->take(1)->first();
        $email = $reset_password->email;
        $token = $reset_password->token;
        $check = (new ResetPasswordService())->CheckEmailToken($email,$token);
        $this->asserttrue($check);
    }

     /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Failure_CheckEmailToken()
    {
        
        $email = str::random(10).'@gmail.com';
        $token = str::random(10);
        $check = (new ResetPasswordService())->CheckEmailToken($email,$token);
        $this->assertFalse($check);
    }

    /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Successfull_SetNewPassword()
    {
        $user = User::take(1)->first();
        $password = str::random(10);
        $check = (new ResetPasswordService())->SetNewPassword($user,$password);
        $this->assertTrue($check);
    }





}

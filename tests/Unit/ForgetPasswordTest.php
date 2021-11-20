<?php

namespace Tests\Unit;

use App\Models\User; 
use App\Services\Auth\ForgetPasswordService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    /**
     * check successfull testcase of check if user is exist.
     *
     * @return void
     */
    public function test_Successfull_CheckIfUserExist()
    {
        $user = User::take(1)->first();
        $check = (new ForgetPasswordService())->CheckIfUserExist($user->email);
        $this->assertTrue($check); 
    }

    /**
     * check failure testcase of check if user is exist.
     *
     * @return void
     */
    public function test_Failure_CheckIfUserExist()
    {
        $email = str::random(10).'@gmail.com';
        $check = (new ForgetPasswordService())->CheckIfUserExist($email);
        $this->assertFalse($check); 
    }

     /**
     * Test add token to password_resests table
     *
     * @return void
     */
    public function test_AddToken()
    {
        $user = User::take(1)->first();
        $email = $user->email; 
        $check = (new ForgetPasswordService())->AddToken($email);
        $this->assertNotNull($check);
    }


    /**
     * Test send resest password mail to user
     *
     * @return void
     */
    public function test_SendResetPasswordMail()
    {
      $reset_password =  DB::table('password_resets')->take(1)->first();
       $email = $reset_password->email;
       $token = $reset_password->token;
       $check = (new ForgetPasswordService())->SendResetPasswordMail($email, $token);
       $this->assertTrue($check);
    }

    





}
<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

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
        $email = str::random(10) . '@gmail.com';
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
        $check = (new ResetPasswordService())->CheckEmailToken($email, $token);
        $this->asserttrue($check);
    }

    /**
     * test if this email is corrosponding to user in our database.
     *
     * @return void
     */
    public function test_Failure_CheckEmailToken()
    {

        $email = str::random(15) . '@gmail.com';
        $token = str::random(15);
        $check = (new ResetPasswordService())->CheckEmailToken($email, $token);
        $this->assertFalse($check);
    }


    /**
     * test if the new password entered by user matches the old password
     * of user, as new password must be different form old password 
     *
     * @return void
     */
    public function test_Failure_CheckPassword()
    {
        $old_password = Hash::make('Ahmed_123');
        $new_password = 'Ahmed_123';
        $check = (new ResetPasswordService())->CheckPassword($old_password, $new_password);
        $this->assertFalse($check);
    }


    /**
     * test if the new password entered by user matches the old password
     * of user, as new password must be different form old password 
     *
     * @return void
     */
    public function test_Successful_CheckPassword()
    {
        $old_password = Hash::make('Ahmed_987');
        $new_password = 'Ahmed_123';
        $check = (new ResetPasswordService())->CheckPassword($old_password, $new_password);
        $this->assertTrue($check);
    }

    /**
     * test if this set new password to out data base
     *
     * @return void
     */
    public function test_Successfull_SetNewPassword()
    {
        $user = User::take(1)->first();
        $password = str::random(10);
        $check = (new ResetPasswordService())->SetNewPassword($user, $password);
        $this->assertTrue($check);
    }

    //TODO: add success request and check token 
}

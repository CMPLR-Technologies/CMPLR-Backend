<?php

namespace Tests\Unit;

use App\Services\Auth\EmailVerificationService; 
use App\Models\User;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * Test : IsEmailVerified which check wether email verified or not
     *
     * @return void
     */
    public function test_is_email_verified()
    {
        $user =User::take(1)->first();
        $check = (new EmailVerificationService())->IsEmailVerified($user);
        $this->assertFalse($check);
    }

    /**
     * Test : VerifyEmail which make user's email as verified
     *
     * @return void
     */
    public function test_verify_email()
    {
        $user =User::take(1)->first();
        $check = (new EmailVerificationService())->VerifyEmail($user);
        $this->assertTrue($check);
    }

}

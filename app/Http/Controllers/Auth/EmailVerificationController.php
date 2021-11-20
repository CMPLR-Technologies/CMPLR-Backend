<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | EmailVerification Controller 
    |--------------------------------------------------------------------------|
    | This controller handles send and verify email of existing users 
    |
   */
    protected $emailVerificationService;

     /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function SendVerificationEmail (Request $request )
    {
        // chcking wether the user already verified the email
            if ($this->emailVerificationService->IsEmailVerified($request->user())) {
                return response()->json(['message'=>'Email Already Verified'],200);
            }
            // send email verification user
            $this->emailVerificationService->SendingEmailVerification($request->user());

            return response()->json(['message'=>'Email Verification sent'],200);
    }

    public function Verify(EmailVerificationRequest $request)
    {
        // checking wether the email is already verified 
        if ($this->emailVerificationService->IsEmailVerified($request->user())) {
            return response()->json(['message'=>'Email Already Verified'],200);
        }
        // making the email as verified and creat event verified for the user
        $this->emailVerificationService->VerifyEmail($request->user());
        
        return response()->json(['message'=>'Email has been Verified'],200);
    }
}

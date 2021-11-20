<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        // chcking wether the user already verified the email
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email Already Verified'], 200);
        }
        // send enmail verification user
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Email Verification sent'], 200);
    }

    public function verify(EmailVerificationRequest $request)
    {
        // checking wether the email is already verified 
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email Already Verified'], 200);
        }
        // making the email as verified and creat event verified for the user
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return response()->json(['message' => 'Email has been Verified'], 200);
    }
}
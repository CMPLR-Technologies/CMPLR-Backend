<?php

namespace App\Http\Misc\Helpers;

class Errors
{
    // auth errors
    const COMPLETED_PROFILE_BEFORE = 'you have completed your profile before.';
    const COMPLETED_PROFILE_MUST = 'you must complete your profile.';
	const NOT_FOUND_USER  = 'There is no account associated with this email.';
    const WRONG_PASSWORD  = 'Invalid login, wrong email or password.';
    const NOT_VERIFIED_USER = 'Non Verified User.';
    const NO_FOLLOW = 'you cannot unfollow a non followed user.';

    //records errors
    const EXISTS="Record already exists!";
    const NOT_EXISTS="Record not exists!";

	// general errors
	const TESTING  = 'Invalid parameter.';
	const UNAUTHENTICATED  = 'Unauthenticated.';
	const UNAUTHORIZED = 'Unauthorized.';
	const GENERAL = "General error ,try again later!";


    //save for later
    const QUANTITY_NOT_AVAILABLE ="This quantity is bigger than available number";


    const INVALID_EMAIL_VERIFICATION_URL = "that email is invalid to verification";
    const EMAIL_ALREADY_VERIFIED ='api.email_already_verified';
    const CODE= "Invalid code!";

    //Codes Error 
    const Code422 = "Invalid Data";

    // generate token
    const GENERATE_TOKEN = "Error while ResetPassword";
    const TOKEN_ERROR = "Invalid Token";

    // SentMail
    const ERROR_MAIL = "Error while Sending Mail";
}


<?php

namespace App\Http\Misc\Helpers;

class Errors
{
    // auth errors
    const COMPLETED_PROFILE_BEFORE = 'You have completed your profile before.';
    const COMPLETED_PROFILE_MUST = 'You must complete your profile.';
    const NOT_FOUND_USER  = 'There is no account associated with this email.';
    const WRONG_PASSWORD  = 'Invalid login, wrong email or password.';
    const NOT_VERIFIED_USER = 'Non Verified User.';
    const NO_FOLLOW = 'You cannot unfollow a non followed user.';

    // records errors
    const EXISTS = "Record already exists!";
    const NOT_EXISTS = "Record not exists!";

    // general errors
    const TESTING  = 'Invalid parameter.';
    const UNAUTHENTICATED  = 'Unauthenticated.';
    const UNAUTHORIZED = 'Unauthorized.';
    const GENERAL = "General error ,try again later!";

    // save for later
    const QUANTITY_NOT_AVAILABLE = "This quantity is bigger than available number";

    const INVALID_EMAIL_VERIFICATION_URL = "That email is invalid to verification";
    const EMAIL_ALREADY_VERIFIED = 'Email is already verified';
    const CODE = "Invalid code!";

    // generate token
    const GENERATE_TOKEN_ERROR = "Error while Create Token";
    const TOKEN_ERROR = "Invalid Token";

    // sent mail
    const ERROR_MAIL = "Error while Sending Mail";

    // codes errors
    const ERROR_MSGS_400 = "Invalid Data";
    const ERROR_MSGS_401 = "Unauthorized User";
    const ERROR_MSGS_403 = "Forbidden";
    const ERROR_MSGS_404 = "Not Found";
    const ERROR_MSGS_409 = "Conflict";
    const ERROR_MSGS_422 = "Unprocessable Entity";
    const ERROR_MSGS_500 = "Internal Server Error";

    // duplicate password
    const DUPLICATE_PASSWORD = "New Password Cannot be Equal Old Password";

    // creation errors
    const CREATE_ERROR = "Error While creating";

    const AUTHORIZED = "User is not authorized to do this action";
}
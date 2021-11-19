<?php

namespace App\Services\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService {
     /*
     |--------------------------------------------------------------------------
     | EmailVerificationService
     |--------------------------------------------------------------------------|
     | This Service handles all EmailVerification controller needed 
     |
     */    

    /**
     * Check wether the user's email is verified 
     * 
     * @param User $ user 
     * 
     * @return Bool
     * @author Yousif Ahmed 
     */
    public function IsEmailVerified(User $user):Bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Sending Email Verification Notification 
     * 
     * @param User $user 
     * 
     * @return void
     * @author Yousif Ahmed 
     */
     public function SendingEmailVerification (User $user)
     {
         $user->sendEmailVerificationNotification(); 
     }

     /**
      * Verify user's email
      *
      * @param User $user
      *
      * @return Bool
      * @author Yousif Ahmed 
      */
      public function VerifyEmail (User $user)
      { 
         if ($user->markEmailAsVerified())
         {
            event(new Verified($user));
         }

      }

    
}

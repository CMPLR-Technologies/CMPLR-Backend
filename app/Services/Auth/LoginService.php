<?php

namespace App\Services\Auth;
use App\Models\User;

class LoginService {

     /*
     |--------------------------------------------------------------------------
     | LoginService
     |--------------------------------------------------------------------------|
     | This Service handles all Login controller needed 
     |
     */     
     
     /**
      * Checking wither the login user authorized to our system 
      * 
      * @param array $loginCredenials
      *
      * @return Bool 
      * @author Yousif Ahmed 
      */
     public function CheckUserAuthorized(array $loginCredenials):Bool
     {
          return auth()->attempt($loginCredenials) ;
     }

     /**
      * Create token for the user 
      * 
      * @param user $user
      * 
      * @return String $user_login_token 
      * @author Yousif Ahmed 
      */
     public function CreateUserToken(User $user):String
     {
          //generate the token for the user
          $userLoginToken = $user->CreateToken('authToken')->accessToken;
   
          return $userLoginToken ;
     
     }  

    /**
      * Checking wether the user is authenticated 
      *
      * @return Bool 
      * @author Yousif Ahmed 
      */ 
     public function CheckUserAuthenticated():Bool
     {
          return auth()->check() ;
     }

     
     /**
      * Revoke user token for logout 
      *
      *@param User $user
      */
     public function RevokeUserToken (User $user)
     {
          $userToken = $user->token();
          $userToken->revoke();
     }


     
}
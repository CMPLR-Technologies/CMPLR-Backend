<?php

namespace App\Services\Auth;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordService
{


    /**
     * Check if user want to change password is exist in our DataBase.
     *
     * @param string $email
     * 
     * @return Bool
     */
    public function CheckIfExist(string $email): Bool
    {
        if (User::where('email', $email)->doesntExist())
            return false;
        return true;
    }

    /**
     * Generate Token
     *
     * 
     * @return string
     */
    public function GenerateToken(): string
    {
        $token = Str::random(60);
        return $token;
    }


    /**
     * Generate Token and Add insert it in reset_password 
     *
     * @param string $email
     * 
     * @return string
     */
    public function AddToken(string $email): string
    {
        $token = $this->GenerateToken();
        $reset_password = DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        if (!$reset_password)
            return null;

        return $token;
    }


    /**
     *  Send Mail to user to change his password
     *
     * @param string $email
     * @param string $token
     * 
     * @return bool
     */
    public function SendResetPasswordMail(string $email, string $token): bool
    {
        try {
            // Mail::send return Void so it needs try and catch
            Mail::to($email)->send(new ResetPasswordMail($token));
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}

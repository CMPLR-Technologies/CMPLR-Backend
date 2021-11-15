<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function ResetPassword(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        if (!$passwordResets = DB::table('password_resets')->where('token',$token)->first()){
            return response([
                'message'=>'Invalid token'
            ],400);
        }
        if(!$passwordResets = DB::table('password_resets')->where('email',$email)->first())
        {
            return response([
                'message'=>'Invalid user'
            ],400); 
        }

        if(!$user = User::where('email',$passwordResets->email))
        {
            return response([
                'message'=>'User doesn\'t exist'
            ],404);
        }

        $user->password=Hash::make($request->input('password'));
        $user->save();
        $passwordResets = DB::table('password_resets')->where('token',$token)->delete();
        
        return response([
            'message'=>'success'
        ]);

    }
    public function GetResetPassword(string $token)
    {
        if (!$passwordResets = DB::table('password_resets')->where('token',$token)->first()){
            return response([
                'message'=>'Invalid token'
            ],400);
        }
        return response([
            'email'=>$passwordResets->email,
        ]); 
    }
}

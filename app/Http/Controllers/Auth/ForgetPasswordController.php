<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    /**
     * @OA\Get(
     * path="/forgot_password",
     * summary="forget password for existing user",
     * description="User can reset password for existing email",
     * operationId="forgetPassword",
     * tags={"Auth"},
     * @OA\Response(
     *    response=200,
     *    description="Successfully redirect",
     * ),
     *   @OA\Response(
     *      response=404,
     *       description="Not Found",
     *   ),
     * )
     */

    public function ForgetPassword(Request $request)
    {

        $email = $request -> input('email');

        if(User::where('email',$email)->doesntExist()){
            return response([
                'message'=>'User doesn\'t exist!'
            ],404);
        }
        $token = Str::random(30);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            Mail::send('emails.demoEmail',
                ['token' => $token],
                function (Message $message) use ($email) {
                    $message->to($email);
                    $message->subject('Reset your password');
            });

            return response([
                'message'=>'Check your email'
            ]);
        } catch(\Exception $exception){
            return response ([
                'message'=>$exception->getMessage()
            ],400);
        }
    }


    public function reset(Request $request)
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



}

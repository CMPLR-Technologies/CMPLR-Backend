<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use App\Http\Misc\Helpers\Errors;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{

    protected $ResetPasswordService;

    /**
     * Instantiate a new instance of ResetPasswordService.
     *
     * @return void
     */
    public function __construct(ResetPasswordService $ResetPasswordService)
    {
        $this->ResetPasswordService = $ResetPasswordService;
    }

    public function ResetPassword(ResetPasswordRequest $request)
    {
        if (!$this->ResetPasswordService->CheckEmailToken($request->email, $request->token))
            return $this->error_response(Errors::TOKEN_ERROR, 400);

        $user = $this->ResetPasswordService->GetUser($request->email);
        if (!$user)
            return  $this->error_response(Errors::NOT_FOUND_USER, 404);

        $check_password = $this->ResetPasswordService->CheckPassword($user->password,$request->password);
        if(!$check_password)
            return  $this->error_response(Errors::NOT_FOUND_USER, 404);

        if (!$this->ResetPasswordService->SetNewPassword($user, $request->password))
            return  $this->error_response(Errors::DUPLICATE_PASSWORD, 400);
        
        event(new PasswordReset($user));

        return  $this->success_response($user, 200);
    }

    public function GetResetPassword(string $token)
    {
        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return response([
                'message' => 'Invalid token'
            ], 400);
        }
        return $this->success_response(['email'=> $passwordResets->email]);
    }
}

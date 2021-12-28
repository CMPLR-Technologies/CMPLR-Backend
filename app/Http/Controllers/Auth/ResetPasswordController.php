<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use App\Http\Misc\Helpers\Errors;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\Blog;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Reset Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    |
    */
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
    /**
     * Function ResetPassword is responsible for handling and
     * validating  user password reset
     * 
     * @param ResetPasswordRequest
     * 
     * @return Response
     */
    /**
     * @OA\post(
     * path="/reset_password",
     * summary="reset password for existing user",
     * description="User can reset password for existing email",
     * operationId="forgetPassword",
     * tags={"Auth"},
     *  @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="token",
     *         in="query",
     *         required=true,
     *      ),
     *   @OA\Parameter(
     *         name="Password",
     *         in="query",
     *         required=true,
     *      ),
     *   @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Email"},
     *       required={"token"},
     *       required={"password"},
     *       required={"password_confirmation"},
     *       @OA\Property(property="email", type="email", format="email", example="tumblr.email@gmail.com"),
     *       @OA\Property(property="token", type="string",example="XTz5MunRlmR9k3IHYnme4oVyryPN20lnSgq8UjfX97WudDesfpyF98bhoHV6"),
     *       @OA\Property(property="password", type="password", format="password", example="*************"),
     *       @OA\Property(property="password_confirmation", type="password", example="*************"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *      @OA\JsonContent(
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *           ),
     *       @OA\Property(property="user", type="string", format="text", example="{user data}"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=404,
     *       description="Not Found",
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="invalid Data",
     *   ),
     * )
     */
    /**
     * this function handle reset the user new password
     * @param ResetPasswordRequest $request
     *
     * @return response
     */
    public function ResetPassword(ResetPasswordRequest $request)
    {
        // check if the token is coresponding to request email
        if (!$this->ResetPasswordService->CheckEmailToken($request->email, $request->token))
            return $this->error_response(Errors::TOKEN_ERROR,'',400);

        //get User
        $user = $this->ResetPasswordService->GetUser($request->email);
        if (!$user)
            return  $this->error_response(Errors::NOT_FOUND_USER,'',404);

        // check that new password is same as the old one
        $check_password = $this->ResetPasswordService->CheckPassword($user->password, $request->password);
        if (!$check_password)
        {
            $error['password']= [Errors::DUPLICATE_PASSWORD];
            return  $this->error_response(Errors::ERROR_MSGS_400,$error,400);
        }

        // Set the new password
        if (!$this->ResetPasswordService->SetNewPassword($user, $request->password))
            return  $this->error_response(Errors::ERROR_MSGS_500,['error in set new password'],500);

        // login after reset 
        // Create access token to user
        $userLoginToken = $user->CreateToken('User_access_token')->accessToken;

        // set the response
        $response['user'] = $user;
        $response['blog'] = Blog::find($user->primary_blog_id);
        $response['token'] = $userLoginToken;

        // Fire PasswordReset event
        event(new PasswordReset($user));
        $resource =  new RegisterResource($response);
        // return proper response
        return  $this->success_response($resource, 200);
    }


     /**
     * @OA\get(
     * path="/reset_password/{token}",
     * summary="get email for reset password for  user",
     * description="User can reset password for existing email",
     * operationId="GetResestPassword",
     * tags={"Auth"},
     *  @OA\Parameter(
     *         name="token",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully",
     *  @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="success"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *              @OA\Property(property="token", type="string", format="text", example="4Y9ZEJqWEABGHkzEXAqNI1F9UZKtKeZVdIChNXBapp9w7XP6mwQZeBXEebMU"),
     *             @OA\Property(property="email", type="string",format="text", example="ahmed.mohamed.abdelhamed2@gmail.com"),
     *           ),
     * ),
     * ),
     *   @OA\Response(
     *      response=404,
     *       description="Not Found",
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="invalid Data",
     *   ),
     * )
     */
    /**
     * this function get the token and email of user 
     * @param string $token
     * @return response
     */
    public function GetResetPassword(string $token)
    {
        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return $this->error_response(Errors::ERROR_MSGS_400, ['Invalid token'], 400);
        }
        $response['email'] = $passwordResets->email;
        $response['token'] = $passwordResets->token;
        return $this->success_response($response,200);
    }
}

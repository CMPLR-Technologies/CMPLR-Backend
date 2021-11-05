<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

     public function forgetPassword ()
     {

     }
     /**
     * @OA\Post(
     * path="/forgot_password",
     * summary="reset password for existing user",
     * description="User can reset password for existing email",
     * operationId="resetPassword",
     * tags={"Auth"},
     * *  @OA\Parameter(
     *         name="Email",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully sent email to reset password",
     * ),
     *   @OA\Response(
     *      response=403,
     *       description="Forbidden",
     *   ),
     * )
     */

    public function resetPassword ()
    {

    }
}

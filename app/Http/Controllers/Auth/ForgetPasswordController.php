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

    public function forgetPassword()
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

    public function resetPassword()
    {
    }
    /**
     * @OA\Post(
     * path="/user/resend_verification_email",
     * summary="resend verification email for the user",
     * description="User can get verification for existing email",
     * operationId="resendVerificationEmail",
     * tags={"Auth"},
     * @OA\Response(
     *    response=200,
     *    description="Successfully sent email to reset password",
     *      @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Email sent to yousef.elftah00@eng-st.cu.edu.eg!")
     *        )
     *     )
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * )
     */


    public function resendVerificationEmail()
    {
    }
}
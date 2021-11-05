<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersettingController extends Controller
{
    /**
     *	@OA\Get
     *	(
     * 		path="/settings/account",
     * 		summary="User setting",
     * 		description="Retrieve Account Setting for User.",
     * 		operationId="accountSettings",
     * 		tags={"Settings"},
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="meta", type="object",
     *          @OA\Property(property="status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",          
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="example@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         example="password123"
     *                      ),
     *                      @OA\Property(
     *                         property="google_login",
     *                         type="Boolean",
     *                         example=false
     *                      ),    
     *                      @OA\Property(
     *                         property="account_activity",
     *                         type="Boolean",
     *                         example=true
     *                      ),   
     *                      @OA\Property(
     *                         property="two-factor_authentication",
     *                         type="Boolean",
     *                         example=false
     *                      ), 
     *                      @OA\Property(
     *                         property="filtering_tags",
     *                         type="string",
     *                         example="summer,winter,sunny"
     *                      ),                       
     *                  ),
     *                ),          
     *   ),
     * )
     */

    public function accountSettings()
    {
    }

    /**
     * @OA\Delete(
     *   path="/settings/account/delete",
     *   summary="Delete User Account",
     *   description="This method is used to delete the account of the authenticated user.",
     *   operationId="deleteAccount",
     *   tags={"Settings"},
     *
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     *   ),
     *  
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       )
     *     )
     *   )
     * )
     */
    public function deleteAccount()
    {
    }
}
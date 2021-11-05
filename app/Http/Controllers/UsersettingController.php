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
     * 		operationId="GEtAccountSetting",
     * 		tags={"User"},
     *
     * @OA\Response(
     *    response=200,
     *    description="sucess",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",          
     *                      @OA\Property(
     *                         property="Email",
     *                         type="string",
     *                         example="example@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="Password",
     *                         type="string",
     *                         example="password123"
     *                      ),
     *                      @OA\Property(
     *                         property="GoogleLogin",
     *                         type="Boolean",
     *                         example=false
     *                      ),    
     *                      @OA\Property(
     *                         property="account_activity",
     *                         type="Boolean",
     *                         example=true
     *                      ),   
     *                      @OA\Property(
     *                         property="Two-factor_authentication",
     *                         type="Boolean",
     *                         example=false
     *                      ), 
     *                      @OA\Property(
     *                         property="filtteringTags",
     *                         type="string",
     *                         example="summer,winter,sunny"
     *                      ),                       
     *                  ),
     *                ),          
     *   ),
     * )
     */

    public function AccountSetting(){

    }
}

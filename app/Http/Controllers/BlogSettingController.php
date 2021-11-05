<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogSettingController extends Controller
{
       /**
     *	@OA\Get
     *	(
     * 		path="settings/blog/{Blog identifier}",
     * 		summary="Blog setting",
     * 		description="Retrieve Blog Setting for User.",
     * 		operationId="GEtBlogSetting",
     * 		tags={"BlogSetting"},
     *
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",          
     *                      @OA\Property(
     *                         property="Blog_id",
     *                         type="string/integer",
     *                         example="12135515"
     *                      ),
     *                      @OA\Property(
     *                         property="BlogName",
     *                         type="string",
     *                         example="Summer Photos 2019"
     *                      ),
     *                      @OA\Property(
     *                         property="Blogtitle",
     *                         type="string",
     *                         example="summer"
     *                      ),    
     *                      @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         example="https://www.example.com/image/avatar.png"
     *                      ),   
     *                      @OA\Property(
     *                         property="Replies",
     *                         type="string",
     *                         example="Every can reply"
     *                      ), 
     *                      @OA\Property(
     *                         property="Ask",  type="object",
     *                           @OA\Property(
     *                              property="permit ask",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="Ask page title",
     *                              type="string",
     *                              example=""
     *                           ),  
     *                           @OA\Property(
     *                              property="permit anonymous questions",
     *                              type="Boolean",
     *                              example=false
     *                           ),                            
     *                         
     *                      ), 
     *                      @OA\Property(
     *                         property="Submissions",  type="object",
     *                           @OA\Property(
     *                              property="permit submit",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="Submissions page title",
     *                              type="string",
     *                              example="Submit a post"
     *                           ),  
     *                           @OA\Property(
     *                              property="Submissions guidelines",
     *                              type="string",
     *                              example="Don't violate the community rules"
     *                           ),    
     *                           @OA\Property(
     *                              property="is_text_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),   
     *                           @OA\Property(
     *                              property="is_photo_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_quote_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_link_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_video_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),                       
     *                         
     *                      ),
     *                     @OA\Property(
     *                        property="permit Messaging",
     *                        type="Boolean",
     *                        example=true
     *                     ),  
     *                     @OA\Property(
     *                        property="Protected",
     *                        type="Boolean",
     *                        example=false
     *                     ),  
     * 
     *                      @OA\Property(
     *                         property="Visibility",  type="object",
     *                           @OA\Property(
     *                              property="Dashboard_Hide",
     *                              type="Boolean",
     *                              example=false
     *                           ),
     *                           @OA\Property(
     *                              property="Search_Hide",
     *                              type="Boolean",
     *                              example=false
     *                           ),                             
     *                         
     *                      ), 
     * 
     *                     @OA\Property(
     *                        property="Queue", type="object",
     * 
     *                           @OA\Property(
     *                              property="posts_per_day",
     *                              type="integer",
     *                              example=3
     *                           ),
     *                           @OA\Property(
     *                              property="Between",
     *                              type="string",
     *                              example="12am,4pm"
     *                           ),                               
     *                     ),                   
     *                                  
     *                ),
     *            ),          
     *       ),
     *  security ={{"bearer":{}}}
     * )
     */
    public function BlogSetting(){

    }
}

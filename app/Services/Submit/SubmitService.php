<?php

namespace App\Services\Submit;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class SubmitService{

    /*
    |--------------------------------------------------------------------------
    | Submit Service
    |--------------------------------------------------------------------------
    | This class handles the logic of BlogSubmitController
    |
   */

    /**
     * implements the logic of creating a Submit
     * 
     * @return int
     */
    public function CreateSubmit($request,$blogName)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();
        
        //check if blog exists
        if($blog==null)
        return 404;

        //get user who submitted
        $source_user_id=auth()->id();

        //create submit
        Post::create([
        'blog_id'=>$blog->id,
        'content'=>$request['content'],
        'type'=>$request['type'],
        'source_title'=>$request['title'],
        'mobile'=>$request['mobile'],
        'tags'=>$request['tags'],
        'post_ask_submit'=>'submit',
        'source_user_id'=>$source_user_id,
        ]);    

        return 201;
    }


     /**
     * implements the logic of deleting a Submit
     * 
     * @return int
     */
    public function DeleteSubmit($SubmitId,$user)
    {
        //get target submit
        $submit=Post::all()
            ->where('post_ask_submit','submit')
            ->where('id',$SubmitId)
            ->first();

        //check if Submit exists
        if($submit==null)
            return 404;

        //get target blog
        $blog=Blog::find($submit->blog_id);
        
        //check if the authenticated user is a member of this blog
        if($blog->users()->where('user_id',$user->id)->first() == null)
            return 403;

        //delete 
        $submit->delete();

        return 202;
    }
    


}

<?php

namespace App\Services\Submit;

use App\Models\Blog;
use App\Models\Post;
use Carbon\Carbon;
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
     * implement the logic of creaing a submit
     * @param array $request
     * @param string $blogName 
     * @param User $user
     * @return int
     */
    public function CreateSubmit($request,$blogName,$user)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();
        
        //check if blog exists
        if($blog==null)
            return 404;

        //get user who submitted
        $source_user_id=$user->id;

        //create submit
        Post::create([
            'blog_id'=>$blog->id,
            'blog_name'=>$blogName,
            'content'=>$request['content'],
            'type'=>$request['type'],
            'mobile'=>array_key_exists('mobile',$request )?$request['mobile']:null,
            'tags'=>array_key_exists('submissionTag',$request) && $request['submissionTag']?'["submission"]':null,
            'post_ask_submit'=>'submit',
            'source_user_id'=>$source_user_id,
        ]);    

        return 201;
    }


    /**
     * implement the logic of deleting a submit
     * @param int $SubmitId
     * @param User $user
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
    

    /**
     * implement the logic of approving a submit
     * @param array $request
     * @param int $submitId
     * @param User $user
     * @return int
     */
    public function PostSubmit($request,$submitId,$user)
    {
        //get target submit
        $submit=Post::where('id',$submitId)
            ->where('post_ask_submit','submit')
            ->first();
        
        //check if submit exists
        if($submit==null)
            return 404;


        //get target blog
        $blog=Blog::find($submit->blog_id);

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return 403;

        //turn submit into a normal post
        $submit->content=$request['content'];
        $submit->mobile=array_key_exists('mobile',$request )?$request['mobile']:null;
        $submit->post_ask_submit='post';
        $submit->source_content=array_key_exists('source_content',$request )?$request['source_content']:null;
        $submit->tags=array_key_exists('tags',$request )?$request['tags']:null;
        $submit->state=$request['state'];
        $submit->date=Carbon::now()->toRfc850String();

        //update 
        $submit->update();

        return 200;
    }
}

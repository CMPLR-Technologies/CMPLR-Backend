<?php

namespace Tests\Unit;

use App\Models\BlogUser;
use App\Models\Chat;
use App\Services\Blog\BlogChatService;
use Tests\TestCase;


class BlogChatTest extends TestCase
{
    /**
     * testing succesful valid blog id 
     *
     * @return void
     */
    public function test_success_valid_blog_id()
    {
        $parameter = [
            'blogId' =>BlogUser::take(1)->first()->value('blog_id'),
            'userId' =>BlogUser::take(1)->first()->value('user_id') ,
        ];
        $check = (new BlogChatService)->IsValidBlogId($parameter['blogId'] ,$parameter['userId']);
        $this->assertTrue($check);
    }

     /**
     * testing invalid blog id 
     *
     * @return void
     */
    public function test_fail_valid_blog_id()
    {
        $parameter = [
            'blogId' =>40,
            'userId' =>1,
        ];
        $check = (new BlogChatService)->IsValidBlogId($parameter['blogId'] ,$parameter['userId']);
        $this->assertFalse($check);
    }

     /**
     * testing getting latetst message for specific blog 
     *
     * @return void
     */
    public function test_success_latest_messages()
    {
        $blogId = Chat::take(1)->first()->value('from_blog_id');
        $check = (new BlogChatService)->GetLatestMessages($blogId);
        $this->assertNotNull($check->first());
    }
     /**
    *  testing fail to get latetst message for  undefined blog
    *
    * @return void
    */
   public function test_fail_latest_messages()
   {
       $blogId = 10000;
       $check = (new BlogChatService)->GetLatestMessages($blogId);
       $this->assertNull($check->first());
   }
   
    /**
    * testing getting conversation messages between to blogs 
    *
    * @return void
    */
    public function test_success_get_conversation_messages()
    {
        $fromBlogId =  Chat::take(1)->first()->value('from_blog_id');
        $toBlogId =  Chat::take(1)->first()->value('to_blog_id');

        $check = (new BlogChatService)->GetConversationMessages($fromBlogId ,$toBlogId);
        $this->assertNotNull($check->first());
    }
    /**
    * testing for fail to get messgaes for undefined blog
    *
    * @return void
    */
    public function test_fail_get_conversation_messages()
    {
        $fromBlogId =  10000;
        $toBlogId =  1000;

        $check = (new BlogChatService)->GetConversationMessages($fromBlogId ,$toBlogId);
        $this->assertNull($check->first());
    }
    
     /**
    * testing for succesfully creating messages for defined blogs 
    *
    * @return void
    */
    public function test_success_creating_messages()
    {
        
        $message =[
            'fromBlogId' => Chat::take(1)->first()->value('from_blog_id') ,
            'toBlogId' => Chat::take(1)->first()->value('to_blog_id') ,
            'content' => 'hello cmplr',
        ];
        $check = (new BlogChatService)->CreateMessage($message['content'],$message['fromBlogId'] ,$message['toBlogId'] );
        $this->assertNotNull($check->first());
    }

     /**
    * testing for fail  to creat messgae for undefined blogs 
    *
    * @return void
    */
    public function test_fail_creating_messages()
    {
        
        $message =[
            'fromBlogId' => 1000000 ,
            'toBlogId' => 1000000,
            'content' => 'hello cmplr',
        ];
        $check = (new BlogChatService)->CreateMessage($message['content'],$message['fromBlogId'] ,$message['toBlogId'] );
        $this->assertNull($check);
    }
    /**
     * testing for succesfull getting mark as read
     */

    public function test_success_mark_as_read()
    {
        $fromBlogId =  Chat::take(1)->first()->value('from_blog_id');
        $toBlogId =  Chat::take(1)->first()->value('to_blog_id');
        // for testing database messages
        $messages = (new BlogChatService)->GetConversationMessages($fromBlogId ,$toBlogId);
        // target testing function 
        (new BlogChatService)->MarkAsRead($messages);
        $messgesReaded = (new BlogChatService)->GetConversationMessages($fromBlogId ,$toBlogId);

        $this->assertTrue($messgesReaded->first()->is_read);
    }

}

<?php

namespace Tests\Unit;

use App\Http\Requests\PostRequest;
use App\Models\Blog;
use App\Models\Posts;
use App\Services\Posts\PostsService;
use App\Services\User\UserService;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostsTest extends TestCase
{

    protected static $initialized = FALSE;
    protected static $data;
    /**
     * test user settings
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new PostRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    // test validations

     /**
     * check the validation of content in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateContent()
    {
        $this->assertTrue($this->validateField('content', 'this is the content of the post'));
        $this->assertTrue($this->validateField('content', '@#A$#askd1x 123 '));
        $this->assertTrue($this->validateField('content', '123453789'));

        // content  cannot be 
        //empty
        $this->assertFalse($this->validateField('content', ''));
    }

    /**
     * check the validation of type in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateType()
    {
        $this->assertTrue($this->validateField('type', 'text'));
        $this->assertTrue($this->validateField('type', 'photos'));
        $this->assertTrue($this->validateField('type', 'quotes'));
        $this->assertTrue($this->validateField('type', 'chats'));
        $this->assertTrue($this->validateField('type', 'audio'));
        $this->assertTrue($this->validateField('type', 'videos'));

        // type  cannot be 
        //empty
        $this->assertFalse($this->validateField('type', ''));
        // integer
        $this->assertFalse($this->validateField('type', 12345));
        // invalid type
        $this->assertFalse($this->validateField('type', 'ahmed'));
        $this->assertFalse($this->validateField('type', 'wow'));
        $this->assertFalse($this->validateField('type', 'file'));
        $this->assertFalse($this->validateField('type', 'texts'));
    }



    /**
     * check the validation of blog_name in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateBlogName()
    {
        $this->assertTrue($this->validateField('blog_name', 'ahmed'));
        $this->assertTrue($this->validateField('blog_name', 'Ahmed_123'));
        $this->assertTrue($this->validateField('blog_name', 'Blog_title'));

        // blog_name  cannot be 
        //empty
        $this->assertFalse($this->validateField('blog_name', ''));
        // integer
        $this->assertFalse($this->validateField('blog_name', 12345));
        // contain invalid symbols
        $this->assertFalse($this->validateField('blog_name', 'ahm  $#ed'));
        $this->assertFalse($this->validateField('blog_name', '###$%^$%^#$%^'));
        // more than 22 character
        $this->assertFalse($this->validateField('blog_name', 'sdafjhasdjfhjasdfhkdsjafhdsakjfhjafhsdsafjahsd'));
    }

    /**
     * check the validation of state in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateState()
    {
        $this->assertTrue($this->validateField('state', 'publish'));
        $this->assertTrue($this->validateField('state', 'private'));
        $this->assertTrue($this->validateField('state', 'draft'));

        // state  cannot be 
        //empty
        $this->assertFalse($this->validateField('state', ''));
        // integer
        $this->assertFalse($this->validateField('state', 12345));
        // invalid type
        $this->assertFalse($this->validateField('state', 'ahmed'));
        $this->assertFalse($this->validateField('state', 'wow'));
        $this->assertFalse($this->validateField('state', 'file'));
        $this->assertFalse($this->validateField('state', 'texts'));
    }

    /**
     * check the validation of source_content in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateSourceContent()
    {
        $this->assertTrue($this->validateField('source_content', 'www.google.com'));
        $this->assertTrue($this->validateField('source_content', 'www.geekforgeeks'));
        $this->assertTrue($this->validateField('source_content', 'facebook'));

        // state  cannot be 
        // integer
        $this->assertFalse($this->validateField('source_content', 12345));
    }

    
     /**
     * check the validation of tags in post
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validateTags()
    {
        $this->assertTrue($this->validateField('tags', ['summer','winter']));
        $this->assertTrue($this->validateField('tags', ['geekforgeeks']));
        $this->assertTrue($this->validateField('tags', []));

        // state  cannot be 
        // integer
        $this->assertFalse($this->validateField('tags', 12345));
        // string
        $this->assertFalse($this->validateField('tags', 'winter'));
    }

    // -- testing create post

 
    // testing create post service

    /** @test */
    public function TestCreatePost()
    {
        $blog = Blog::take(1)->first();
        $request = [
            'content' => 'this is the content of the post kljkljkljlkjkl',
            'state' => 'publish',
            'type' => 'photos',
            'blog_id' => $blog->id,
            'blog_name' => $blog->blog_name,
        ];
        $check = (new PostsService())->createPost($request);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestGetPostData()
    {
        $post = Posts::take(1)->first();
        $check = (new PostsService())->GetPostData($post->id);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestGetBlogData()
    {
        $blogName = Blog::take(1)->first()->blog_name;
        $check = (new PostsService())->GetBlogData($blogName);
        $this->assertNotNull($check);
    }
    /** @test */
    public function TestGetBlogDataFailure()
    {
        $check = (new PostsService())->GetBlogData('not_exist_blogname');
        $this->assertNull($check);
    }

    /** @test */
    // test update the post data
    public function TestUpdatePost()
    {
        $post = Posts::inRandomOrder()->first();
        $request = [
            'content' => 'ahmed',
        ];
        $check = (new PostsService())->UpdatePost($post, $request);
        $this->assertNotNull($check);
    }

    /** @test */
    // -- testing delete post
    public function TestDeletePost()
    {
        $post = Posts::inRandomOrder()->first();
        $check = (new PostsService())->DeletePost($post);
        $this->assertNotNull($check);
    }


    // ---  test get posts (radar , dashboard , getpost_by id , get blog_posts)


    /** @test */
    public function TestGetRandomPosts()
    {
        $check = (new PostsService())->GetRandomPost([1]);
        $this->assertNotNull($check);
    }


    /** @test */
    public function TestGetBlogPostsWithNotExistBlogName()
    {
        $check = (new PostsService())->GetBlogByName('not_exist_blogname');
        $this->assertNull($check);
    }

    /** @test */
    public function TestGetBlogPostsWithExistBlogName()
    {
        $blogName = Blog::take(1)->first()->blog_name;
        $check = (new PostsService())->GetBlogByName($blogName);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestGetPostsOfBlog()
    {
        $blogId = Blog::take(1)->first()->id;
        $check = (new PostsService())->GetPostsOfBlog($blogId);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestDashBoard()
    {
        $check = (new UserService())->GetDashBoardPosts([1],[2]);
        $this->assertNotNull($check);
    }
    


    protected function getFieldValidator($field, $value)
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    protected function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}

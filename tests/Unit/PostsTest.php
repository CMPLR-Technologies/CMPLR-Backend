<?php

namespace Tests\Unit;

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

        if (!self::$initialized) {

            $faker = Factory::create(1);
            $request = [
                'email' => $faker->email(),
                'age' => $faker->numberBetween(18, 80),
                'blog_name' => 'A_' . time(),
                'password' => 'Test_pass34',
            ];
            // only needs user to test user settings
            $response = $this->json('POST', '/api/register/insert', $request, ['Accept' => 'application/json']);
            //dd(($response->json()));
            self::$data['token'] = ($response->json())['response']['token'];
            self::$data['user'] = ($response->json())['response']['user'];
            self::$data['id'] =  ($response->json())['response']['user']['id'];
            self::$data['blog_name'] =  ($response->json())['response']['blog_name'];
            self::$data['blog_id'] = ($response->json())['response']['user']['primary_blog_id'];
            $this->email =  ($response->json())['response']['user']['email'];
            self::$data['password'] =  Hash::make('Ahmed_123');
            self::$initialized = TRUE;
        }
    }

    // -- testing create post


    /** --- test request rules validations
     * to create post their are some parameters must be 
     * sent with request 
     * 1) content       2)blog_name
     * 3) type of post  4)state of post
     * and user must be authentication to do this request
     * */

    /** @test */
    public function TestAuthenticationFailure()
    {
        $request = [
            'type' => 'photos',
            'state' => 'private',
            'blog_name' => self::$data['blog_name'],
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json'])->assertStatus(401);
    }

    /** @test */
    public function TestCreatePostWithOutContent()
    {
        $request = [
            'type' => 'photos',
            'state' => 'private',
            'blog_name' => self::$data['blog_name'],
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(422);
    }
    /** @test */
    public function TestCreatePostWithOutState()
    {
        $request = [
            'content' => 'this is the content of the post',
            'type' => 'photos',
            'blog_name' => self::$data['blog_name'],
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(422);
    }
    /** @test */
    public function TestCreatePostWithOutType()
    {
        $request = [
            'content' => 'this is the content of the post',
            'state' => 'private',
            'blog_name' => self::$data['blog_name'],
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(422);
    }

    /** @test */
    public function TestCreatePostWithOutBlogName()
    {
        $request = [
            'content' => 'this is the content of the post',
            'state' => 'private',
            'type' => 'photos',
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(422);
    }

    /** @test */
    public function TestCreatePostWithNotFoundBlogName()
    {
        $request = [
            'content' => 'this is the content of the post',
            'state' => 'private',
            'type' => 'photos',
            'blog_name' => 'not_authrized_blog',
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        // dd($response->json());
        $response->assertStatus(404);
    }

    /** @test */
    public function TestCreatePostWithUnAuthroizedBlogName()
    {
        $blog = Blog::where('blog_name', '!=', self::$data['blog_name'])->first();
        $request = [
            'content' => 'this is the content of the post',
            'state' => 'private',
            'type' => 'photos',
            'blog_name' => $blog->blog_name,
        ];
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        // dd($response->json());
        $response->assertStatus(401);
    }

    // testing create post service

    /** @test */
    public function TestCreatePost()
    {
        $request = [
            'content' => 'this is the content of the post kljkljkljlkjkl',
            'state' => 'publish',
            'type' => 'photos',
            'blog_id' => self::$data['blog_id'],
            'blog_name' => self::$data['blog_name'],
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
        $check = (new PostsService())->GetBlogData(self::$data['blog_name']);
        $this->assertNotNull($check);
    }
    /** @test */
    public function TestGetBlogDataFailure()
    {
        $check = (new PostsService())->GetBlogData('not_exist_blogname');
        $this->assertNull($check);
    }

    /** @test */
    // not found blogname
    public function TestNonFoundBlogNameEditPost()
    {
        $post = Posts::take(1)->first();
        $response = $this->json('Get', 'edit/' . 'not_exist_blogname' . '/' . $post->id, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(404);
    }

    /** @test */
    // not found postid
    public function TestNonFoundPostIdEditPost()
    {
        $blog = Blog::take(1)->first();
        $response = $this->json('Get', 'edit/' . $blog->blog_name . '/' . '99987', ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(404);
    }

    /** @test */
    // not found postid
    public function TestUnAuthrizedEditPost()
    {
        $post = Posts::inRandomOrder()->first();
        $blog = Blog::where('id', '!=', $post->blog_id)->first();
        $response = $this->json('Get', 'api/edit/' . $blog->blog_name . '/' . $post->id, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(401);
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
    public function TestGetPostById()
    {
        // test if their this post_id not found
        $response = $this->json('Get', 'api/posts/' . '99999', ['Accept' => 'application/json']);
        $response->assertStatus(404);
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
        $check = (new PostsService())->GetBlogByName(self::$data['blog_name']);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestGetPostsOfBlog()
    {
        $check = (new PostsService())->GetPostsOfBlog(self::$data['blog_id']);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestDashBoard()
    {
        $check = (new UserService())->GetDashBoardPosts([1],[2]);
        $this->assertNotNull($check);
    }
}

<?php

namespace Tests\Unit;

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
        $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json']);
        $response->assertGuest();
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
        public function TestCreatePostWithUnAuthrizedBlogName()
        {
            $request = [
                'content' => 'this is the content of the post',
                'state' => 'private',
                'type' => 'photos',
                'blog_name' => 'not_authrized_blog_name',
            ];
            $response = $this->json('POST', '/api/posts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
            $response->assertStatus(422);
        }



}

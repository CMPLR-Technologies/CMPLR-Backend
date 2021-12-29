<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\UserService;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{


    protected static $initialized = FALSE;
    protected static $data;
    /**
     * A basic unit test example.
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
                'blog_name' => 'U' . time(),
                'password' => 'Test_pass34',
            ];
            // only needs user to test user settings
            $response = $this->json('POST', '/api/register/insert', $request, ['Accept' => 'application/json']);
            self::$data['token'] = ($response->json())['response']['token'];
            self::$data['id'] =  ($response->json())['response']['user']['id'];
            self::$data['password'] =  Hash::make('Ahmed_123');
            self::$initialized = TRUE;
        }
    }

    // -- Testing user following

    /** @test */
    public function TestUserFollowingAuthtication()
    {
        $user = User::find(self::$data['id']);
        $this->actingAs($user, 'api')->json('Get', '/api/user/followings')->assertStatus(200);
    }

    /** @test */
    public function TestUserFollowingAuthticationFailure()
    {
        $this->json('Get', '/api/user/followings')->assertStatus(401);
    }


    // --Testing User Likes 

    
    /** @test */
    public function TestUserLikesAuthtication()
    {
        $user = User::find(self::$data['id']);
        $this->actingAs($user, 'api')->json('Get', '/api/user/likes')->assertStatus(200);
    }

    /** @test */
    public function TestUserLikesAuthticationFailure()
    {
        $this->json('Get', '/api/user/likes')->assertStatus(401);
    }


    // ---Testing User info


    /** @test */
    public function TestUserInfoAuthtication()
    {
        $user = User::find(self::$data['id']);
        $this->actingAs($user, 'api')->json('Get', '/api/user/info')->assertStatus(200);
    }
    /** @test */
    public function TestUserInfoAuthticationFailure()
    {
        $this->json('Get', '/api/user/info')->assertStatus(401);
    }
    /** @test */
    public function TestGetUserData()
    {
        $user = User::find(self::$data['id']);
        $check =  (new UserService())->GetUserData($user);
        $this->assertNotNull($check);
    }

    /** @test */
    // get number of followers of user
    public function TestGetUserFollowing()
    {
        $check =  (new UserService())->GetUserFollowing(self::$data['id']);
        $this->assertNotNull($check);
    }


    /** @test */
    // get number of followers of user
    public function TestGetUserPosts()
    {
        $user = User::find(self::$data['id']);
        $check =  (new UserService())->GetUserPosts($user);
        $this->assertNotNull($check);
    }


    
    /** @test */
     //Get Blog Data 
    public function TestGetBlogsData()
    {
        $check =  (new UserService())->GetBlogsData(self::$data['id']);
        $this->assertNotNull($check);
    }


}

<?php

namespace Tests\Unit;

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
                'blog_name' => 'Newblog_name3',
                'password' => 'Test_pass34',
            ];
            // only needs user to test user settings
            $response = $this->json('POST', '/api/register/insert', $request, ['Accept' => 'application/json']);
            self::$data['token'] = ($response->json())['response']['token'];
            self::$data['password'] =  Hash::make('Ahmed_123');
            self::$initialized = TRUE;
        }
    }

  
}

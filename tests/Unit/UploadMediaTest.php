<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UploadMedia\HandlerBase64Service;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;
use Tests\TestCase;

class UploadMediaTest extends TestCase
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

    // test image upload

    //validation check

    /** @test */
    public function TestUploadImageUnAuthorized()
    {
        Storage::fake('avatars');
        $response = $this->json('POST', '/api/image_upload', [], ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }

    /** @test */
    public function TestUploadImageWithoutImageFile()
    {
        $response = $this->json('POST', '/api/image_upload', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $response->assertStatus(422);
    }

    /** @test */
    public function TestGenerateName()
    {
        Storage::fake('public');
        $file = File::image('logo.png', 400, 100);
        $user_id = User::take(1)->first()->id;
        $check = (new HandlerBase64Service())->GenerateFileName($file, $user_id);
        $this->assertNotNull($check);
    }


}

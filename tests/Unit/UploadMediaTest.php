<?php

namespace Tests\Unit;

use App\Services\UploadMedia\HandlerBase64Service;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
    /** @test */
    //validation check
    public function TestUploadImageWithoutImageFile()
    {
        Storage::fake('avatars');
        $response = $this->json('POST', '/api/image_upload', [
         
        ], ['Accept' => 'application/json'] );
        $response->assertStatus(401);
    }   

    //
    public function TestGenerateName()
    {
        //(new HandlerBase64Service ())->GenerateImageName('');
    }
    

}

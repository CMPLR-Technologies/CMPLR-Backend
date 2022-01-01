<?php

namespace Tests\Unit;

use App\Http\Requests\SettingsRequest;
use App\Models\Blog;
use App\Models\User;
use App\Services\User\UserSettingService;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserSettingTest extends TestCase
{
    /*
    | This function is responsible for testing 
    | user settings
    */

    // use DatabaseTransactions;



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
                'email' => $faker->unique()->email(),
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
            $this->email =  ($response->json())['response']['user']['email'];
            self::$data['password'] =  Hash::make('Ahmed_123');
            self::$initialized = TRUE;
        }
    }



    /** @test */
    public function SuccessfulConfirmPassword()
    {
        $UserSettingService = new UserSettingService();
        $old_password = Hash::make('Ahmed_123');
        $confirmed =  $UserSettingService->ConfirmPassword('Ahmed_123', $old_password);
        return $this->assertTrue($confirmed);
    }


    /** @test */
    public function FailureConfirmPassword()
    {
        $UserSettingService = new UserSettingService();
        $old_password = Hash::make('Ahmed_123');
        $confirmed =  $UserSettingService->ConfirmPassword('wrong_pass', $old_password);
        return $this->assertFalse($confirmed);
    }


    /** @test */
    public function SuccessfulUpdateEmail()
    {
        $UserSettingService = new UserSettingService();
        $user = User::take(1)->first();
        $confirmed =  $UserSettingService->UpdateEmail( $user->id, 'Email'.time().'@gmail107.com');
        return $this->assertNotNull($confirmed);
    }


    /** @test */
    public function SuccessfulUpdatePassword()
    {
        $UserSettingService = new UserSettingService();
        $user = User::take(1)->first();
        $confirmed =  $UserSettingService->UpdatePassword($user->id, 'New_password_123');
        return $this->assertNotNull($confirmed);
    }

    /** @test */
    public function CheckAuthenticationSuccess()
    {
        $faker = Factory::create(1);
        $request = [
            'email' => $faker->email(),
            'password' => 'Ahmed_123',
        ];
        // no bearer token is given
        $response = $this->json('PUT', '/api/settings/change_email', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . self::$data['token']]);
        $this->assertAuthenticated();
    }

    /** @test */
    public function CheckAuthenticationFailure()
    {
        $faker = Factory::create(1);
        $request = [
            'email' => $faker->email(),
            'password' => $faker->text(8),
        ];
        // no bearer token is given
        $response = $this->json('PUT', '/api/settings/change_email', $request, ['Accept' => 'application/json']);
        // it should be a guest
        $this->assertGuest();
    }

    /** @test */
    public function UpdateSettings()
    {
        $user = User::take(1)->first();
       $check =  (new UserSettingService())->UpdateSettings(
            $user->id,
            [
                'show_badge' => true,
                'text_editor' => 'rich'
            ]
        );
        $this->assertTrue($check);
    }

    //   /** @test */
    // public function CheckGetSettings()
    // {
    //     $user = User::find(self::$data['id']);
    //     $response = $this->actingAs($user, 'api')->json('Get', '/api/user/settings')->assertStatus(200);       
    // }

    

    public static function tearDownAfterClass(): void
    {
        self::$initialized = null;
    }
}

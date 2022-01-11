<?php

namespace Tests\Unit;

use App\Http\Requests\Auth\ChangePasswordRequest;
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


    public function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new ChangePasswordRequest())->rules();
        $this->validator = $this->app['validator'];
    }
  
    /** @test */
    public function SuccessfulConfirmPassword()
    {
        $UserSettingService = new UserSettingService();
        $old_password = Hash::make('HardPass_123');
        $confirmed =  $UserSettingService->ConfirmPassword('HardPass_123', $old_password);
        return $this->assertTrue($confirmed);
    }


    /** @test */
    public function FailureConfirmPassword()
    {
        $UserSettingService = new UserSettingService();
        $old_password = Hash::make('HardPass_123');
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

    // validation 
     /**
     * check the validation of password
     * Enter 
     *
     * @return void
     */
    /** @test */
    public function validatePassword()
    {
        $this->assertTrue($this->validateField('new_password', 'HardPass_123'));
        $this->assertTrue($this->validateField('new_password', '@#A$#askd1x'));

        // Password  cannot be 
        //empty
        $this->assertFalse($this->validateField('new_password', ''));
        //only lower case
        $this->assertFalse($this->validateField('new_password', 'ahmedsss'));
        // only numbers
        $this->assertFalse($this->validateField('new_password', '123455'));
        // only upper case
        $this->assertFalse($this->validateField('new_password', 'AHMED'));
        // less than 8 characters
        $this->assertFalse($this->validateField('new_password', 'Aa@123'));
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

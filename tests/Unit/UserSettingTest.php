<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\UserSettingService; 
use Tests\TestCase;

class UserSettingTest extends TestCase
{
    /**
     * test user settings
     *
     * @return void
     */
    public function test_getting_setting()
    {
        $user_id = User::take(1)->first()->value('id');
        $check = (new UserSettingService() )->GetSettings($user_id);
        $this->assertnotNull($check);
    }
}

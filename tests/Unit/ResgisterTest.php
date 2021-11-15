<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Generator as Faker;
use function PHPUnit\Framework\assertJson;
use App\Models\User;

class ResgisterTest extends TestCase
{
    /**
     * ResgisterTest class used to test all test cases scenarios 
     */

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_Successful_Registration()
    {
        $response = $this->post('api/register/insert',[
            'email'=> 'newemail@gmail15.com',
            'blog_name' => 'newblog15',
            'age' => '24',
            'password'=>'Ahmed_123'
        ])->assertStatus(201)
          ->assertJsonStructure([
            "meta"=>[
                'status',
                'msg',
            ],
            'response'=>[
                'email',
                'blog_name',
                'age',
                'token'
            ]
          ]);

          $this->assertAuthenticated();
    }

    /**
     * Function to test Registertion process with an email or blog_name or both that 
     * are already exist in DataBase 
     * 
     *
     * @return void
     */
    public function test_Registration_with_existEmailandBlogname()
    {
       $randomuser =  User::get()->first();
        $response = $this->post('api/register/insert',[
            'email'=> $randomuser->email,
            'blog_name' =>$randomuser->blog_name,
            'age' => '24',
            'password'=>'Ahmed_123'
        ])->assertStatus(422)
          ->assertJsonStructure([
            "meta"=>[
                'status',
                'msg',
            ],
            'error'=>[
                'email',
                'blog_name',
            ]
          ]);

    }

    /**
     * Function to test Registertion process with an invalid age
     * 
     * @return void
     */
    public function test_Registration_with_invalid_age()
    {
       $randomuser =  User::get()->first();
        $response = $this->post('api/register/insert',[
            'email'=> 'newemail@gmail13.com',
            'blog_name' =>'newblogname13',
            'age' => '11',
            'password'=>'Ahmed_123'
        ])->assertStatus(422)
          ->assertJsonStructure([
            "meta"=>[
                'status',
                'msg',
            ],
            'error'=>[
                'age',
            ]
          ]);

    }

    /**
     * Function to test Registertion process with a weak password
     * 
     * @return void
     */
    public function test_Registration_with_weak_password()
    {
        $response = $this->post('api/register/insert',[
            'email'=> 'newemail@gmail14.com',
            'blog_name' =>'newblogname14',
            'age' => '22',
            'password'=>'ahmed_123' // no upper case 
        ])->assertStatus(422)
          ->assertJson([
            "meta"=>[
                'status'=>'422',
                'msg'=>'',
            ],
            'error'=>[
                'password'=>["The password must contain at least one uppercase and one lowercase letter."],
            ]
          ]);
    }
}

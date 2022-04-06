<?php

namespace Tests\Unit\Http\Controllers\User;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Hash;

class ProfileControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    public function testProfileUrl()
    {
        Session::start();
        $faker = Factory::create();
        $formValue =
        [
            '_token' => csrf_token(),
            'email' => $faker->email,
            'password' => "02112001",
        ];
        $user = User::create($formValue);
        $response = $this->get('/profile/create/'.$user->id);
        $response->assertOk();
    }

    public function testSaveProfile()
    {
        Session::start();
        $faker = Factory::create();
        $formValue =
        [
            '_token' => csrf_token(),
            'email' => $faker->email,
            'password' => "02112001",
        ];
        $user = User::create($formValue);
        $response = $this->post(
            'profile/create/'.$user->id,
            [
                'name' => $faker->name,
                "first_name" => $faker->name,
                "last_name" => $faker->name,
                "dob" => $faker->date('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
                "gender" => $faker->randomElement(['male', 'female']),
                "address" => $faker->name,
                'user_id' => $user->id,
            ]
        );
        $response->assertRedirect("/home");
    }
}

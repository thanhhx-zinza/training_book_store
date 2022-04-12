<?php

namespace Tests\Unit\Http\Controllers\User;

use Hash;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $response = $this->post(
            'register',
            [
                '_token' => csrf_token(),
                'email' => $faker->email,
                'password' => "02112001",
            ]
        );
        $response->assertRedirect('/profile');
    }

    public function testSaveProfile()
    {
        Session::start();
        $faker = Factory::create();
        $response = $this->post(
            'register',
            [
                '_token' => csrf_token(),
                'email' => $faker->email,
                'password' => "02112001",
            ]
        );
        $user = User::orderBy('id', 'DESC')->first();
        $response = $this->post(
            '/login',
            [
                '_token' => csrf_token(),
                'email' => $user->email,
                'password' => "02112001",
            ]
        );
        $response->assertRedirect('/profile');
        $response = $this->post(
            '/profile',
            [
                'name' => $faker->name,
                "first_name" => $faker->name,
                "last_name" => $faker->name,
                "dob" => $faker->date('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
                "gender" => $faker->randomElement(['male', 'female']),
                "address" => $faker->name,
            ]
        );
        $response->assertRedirect("/home");
    }
}

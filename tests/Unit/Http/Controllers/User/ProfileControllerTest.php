<?php

namespace Tests\Unit\Http\Controllers\User;

use Hash;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

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
        $user = User::first();
        $this->be($user);
        $response = $this->get('/profile/create');
        $response->assertViewIs("User.Profile.createProfile");
    }

    public function testSaveProfile()
    {
        Session::start();
        $user = User::first();
        $this->be($user);
        $faker = Factory::create();
        $response = $this->post(
            '/profile',
            [
                '_token' => csrf_token(),
                'name' => $faker->name,
                "first_name" => $faker->name,
                "last_name" => $faker->name,
                "dob" => $faker->date('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
                "gender" => $faker->randomElement(['male', 'female']),
                "address" => $faker->name,
                'avatar' => $this->uploadFile(),
            ]
        );
        $response->assertRedirect('/home');
    }

    public function testUpdateProfile()
    {
        Session::start();
        $user = User::first();
        $this->be($user);
        $faker = Factory::create();
        if ($user->profile) {
            $response = $this->post(
                '/profile/'.$user->profile->id,
                [
                    '_method' => 'PUT',
                    '_token' => csrf_token(),
                    'name' => $faker->name,
                    "first_name" => $faker->name,
                    "last_name" => $faker->name,
                    "dob" => $faker->date('Y-m-d'),
                    'phone_number' => $faker->phoneNumber,
                    "gender" => $faker->randomElement(['male', 'female']),
                    "address" => $faker->name,
                    'avatar' => $this->uploadFile(),
                ]
            );
            $response->assertJson(['status' => 200, 'message' => 'success']);
        }
    }
}

<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexProfile()
    {
        $user = User::first();
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );
        $response->assertOk();
        $response = $this->getJson('api/user-profile');
        $response->assertOk();
    }

    public function testUpdateProfile()
    {
        $user = User::first();
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );
        $response->assertOk();
        $faker = Factory::create();
        $response = $this->postJson(
            "/api/user-profile",
            [
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
        $response->assertOk();
    }
}

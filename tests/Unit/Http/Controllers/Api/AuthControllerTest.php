<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Models\Profile;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginApi()
    {
        $user = User::first();
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );
        if ($user->profile == null) {
            Profile::create(
                [
                    'user_id' => $user->id,
                    'name' => '',
                    'first_name' => '',
                    'last_name' => '',
                    'phone_number' => '',
                    'gender' => '',
                    'dob' => now(),
                    'address' => '',
                ]
            );
        }
        $response->assertOk();
    }

    public function testLoginApiFail()
    {
        $user = User::first();
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'password1',
            ]
        );
        $response->assertJson(['message' => 'Unauthorized']);
    }
}

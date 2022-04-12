<?php

namespace Tests\Unit\Http\Controllers\User\Auth;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Hash;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLoginUrl()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function testLogin()
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
        $response->assertRedirect('admin/profile');
    }

    public function testLoginFail()
    {
        Session::start();
        $user = User::first();
        $response = $this->post(
            '/login',
            [
                '_token' => csrf_token(),
                'email' => $user->email,
                'password' => "password2",
            ]
        );
        $response->assertRedirect('/login');
    }

    public function testLoginWithEmptyProfile()
    {
        Session::start();
        $faker = Factory::create();
        $formValue =
        [
            'email' => $faker->email,
            'password' => Hash::make(1234),
        ];
        $user = User::create($formValue);
        $response = $this->post(
            '/login',
            [
                '_token' => csrf_token(),
                'email' => User::orderBy('id', 'DESC')->first()->email,
                'password' => 1234,
            ]
        );
        $response->assertRedirect('admin/profile');
    }
}

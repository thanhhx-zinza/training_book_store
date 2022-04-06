<?php

namespace Tests\Unit\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\Session;
use Hash;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRegisterUrl()
    {
        $response = $this->get('/register');
        $response->assertOk();
    }

    public function testRegsiter()
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
        $response->assertStatus(302);
    }
}

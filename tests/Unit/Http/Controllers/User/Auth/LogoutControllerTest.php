<?php

namespace Tests\Unit\Http\Controllers\User\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;

class LogoutControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLogout()
    {
        Session::start();
        $user = User::first();
        $this->be($user);
        $response = $this->delete('/logout', ['_token' => csrf_token()]);
        $response->assertRedirect('/login');
    }
}

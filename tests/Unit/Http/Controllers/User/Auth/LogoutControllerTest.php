<?php

namespace Tests\Unit\Http\Controllers\User\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $response = $this->delete('/logout');
        $response->assertRedirect('/login');
    }
}
